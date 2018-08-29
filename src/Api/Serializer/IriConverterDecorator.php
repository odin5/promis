<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 28.08.2018 13:02
 */

namespace App\Api\Serializer;


use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Api\IriConverterInterface;
use ApiPlatform\Core\Api\OperationType;
use ApiPlatform\Core\Api\UrlGeneratorInterface;
use ApiPlatform\Core\Api\IdentifiersExtractorInterface;
use ApiPlatform\Core\Bridge\Symfony\Routing\RouteNameResolverInterface;
use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Metadata\Property\Factory\PropertyMetadataFactoryInterface;
use ApiPlatform\Core\Metadata\Property\Factory\PropertyNameCollectionFactoryInterface;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Routing\Exception\ExceptionInterface as RoutingExceptionInterface;
use Symfony\Component\Routing\RouterInterface;

class IriConverterDecorator implements IriConverterInterface
{

    protected $decorated;
    protected $annotationReader;
    protected $router;
    protected $identifiersExtractor;
    protected $routeNameResolver;
    protected $propertyNameCollectionFactory;
    protected $propertyMetadataFactory;
    protected $propertyAccessor;

    public function __construct(IriConverterInterface $decorated, Reader $annotationReader, RouterInterface $router,
            IdentifiersExtractorInterface $identifiersExtractor, RouteNameResolverInterface $routeNameResolver,
            PropertyNameCollectionFactoryInterface $propertyNameCollectionFactory,
            PropertyMetadataFactoryInterface $propertyMetadataFactory, PropertyAccessorInterface $propertyAccessor)
    {
        $this->decorated = $decorated;
        $this->annotationReader = $annotationReader;
        $this->router = $router;
        $this->identifiersExtractor = $identifiersExtractor;
        $this->routeNameResolver = $routeNameResolver;
        $this->propertyNameCollectionFactory = $propertyNameCollectionFactory;
        $this->propertyMetadataFactory = $propertyMetadataFactory;
        $this->propertyAccessor = $propertyAccessor;
    }

    public function getIriFromResourceClass(string $resourceClass, int $referenceType = UrlGeneratorInterface::ABS_PATH): string
    {
        $ann = $this->annotationReader->getClassAnnotation(new \ReflectionClass($resourceClass), ApiResource::class);
        if(!empty($ann) && !empty($ann->iri)) return $ann->iri;
        return $this->decorated->getIriFromResourceClass($resourceClass, $referenceType);
    }

    /**
     * Original getIriFromItem() is only able to generate routes with single parameter "id", and if there is multiple
     * identifiers on entity (e.g. plan, turn, work), it joins them with semicolon to single string
     * (e.g. 'plan=1;turn=2;work=3'), which is supplied to "id" param in the route. Does not make sense.
     * For multiple identifiers, I want URL like /plans/{plan}/slots/{work}/{turn}, so before calling the original
     * method, I'll try if the route is able to accept all identifiers. If it won't work, the original method is called.
     */
    public function getIriFromItem($item, int $referenceType = UrlGeneratorInterface::ABS_PATH): string
    {
        $resourceClass = class_exists(ClassUtils::class) ? ClassUtils::getClass($item) : \get_class($item);
        $identifiers = $this->identifiersExtractor->getIdentifiersFromItem($item);
        if(count($identifiers) == 1 && array_keys($identifiers)[0] === 'id') {
            $idAgain = null;
            foreach ($this->propertyNameCollectionFactory->create($resourceClass) as $propertyName) {
                if(null !== $idAgain) break;
                $propertyMetadata = $this->propertyMetadataFactory->create($resourceClass, $propertyName);
                $isId = $propertyMetadata->isIdentifier();
                if (null === $isId || false === $isId) continue;

                $idAgain = $this->propertyAccessor->getValue($item, $propertyName);
                if (\is_object($idAgain) && method_exists($idAgain, 'getId')) {
                    $identifiers[$propertyName] = $idAgain->getId();
                }
            }
        }
        if(!empty($identifiers) && (count($identifiers) > 1 || !array_key_exists('id', $identifiers))) {
            $routeName = $this->routeNameResolver->getRouteName($resourceClass, OperationType::ITEM);
            try {
                return explode('?', $this->router->generate($routeName, $identifiers, $referenceType))[0];
            }
            catch (RuntimeException $e) { }
            catch (RoutingExceptionInterface $e) { }
        }
        $res = $this->decorated->getIriFromItem($item, $referenceType);
        if(empty($res)) return $this->getIriFromResourceClass(get_class($item));
    }

    public function getItemFromIri(string $iri, array $context = [])
    {
        return $this->decorated->getItemFromIri($iri, $context);
    }

    public function getItemIriFromResourceClass(string $resourceClass, array $identifiers, int $referenceType = UrlGeneratorInterface::ABS_PATH): string
    {
        return $this->decorated->getSubresourceIriFromResourceClass($resourceClass, $identifiers, $referenceType);
    }

    public function getSubresourceIriFromResourceClass(string $resourceClass, array $identifiers, int $referenceType = UrlGeneratorInterface::ABS_PATH): string
    {
        return $this->decorated->getSubresourceIriFromResourceClass($resourceClass, $identifiers, $referenceType);
    }
}