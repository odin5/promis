<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 27.08.2018 16:43
 */

namespace App\Api\Swagger;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        // e.g. add a custom parameter
        //$docs['paths']['/foos']['get']['parameters'][] = $customDefinition;

        return $docs;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}