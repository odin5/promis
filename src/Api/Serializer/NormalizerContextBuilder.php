<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 27.08.2018 16:21
 */
namespace App\Api\Serializer;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

class NormalizerContextBuilder implements SerializerContextBuilderInterface
{
    private $decorated;
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $context[AbstractObjectNormalizer::ENABLE_MAX_DEPTH] = true;
        // Add `admin:read` for normalization requests
        // Otherwise, add `admin:write` for denormalization requests
        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $context['groups'][] = $normalization ? 'admin:read' : 'admin:write';
        }

        return $context;
    }
}