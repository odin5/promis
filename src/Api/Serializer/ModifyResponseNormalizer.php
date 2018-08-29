<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 27.08.2018 17:28
 */

namespace App\Api\Serializer;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class ModifyResponseNormalizer implements ContextAwareNormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    private const APP_NORMALIZER_ALREADY_CALLED = 'APP_NORMALIZER_ALREADY_CALLED';

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function normalize($object, $format = null, array $context = [])
    {

        return $this->passOn($object, $format, $context);
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        // Make sure we're not called twice
        if (isset($context[self::APP_NORMALIZER_ALREADY_CALLED])) {
            return false;
        }

        return true;//$data instanceof Book;
    }

    private function passOn($object, $format = null, array $context = [])
    {
        if (!$this->serializer instanceof NormalizerInterface) {
            throw new \LogicException(sprintf('Cannot normalize object "%s" because the injected serializer is not a normalizer', $object));
        }

        $context[self::APP_NORMALIZER_ALREADY_CALLED] = true;

        return $this->serializer->normalize($object, $format, $context);
    }
}