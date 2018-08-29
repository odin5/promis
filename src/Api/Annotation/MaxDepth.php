<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 28.08.2018 19:10
 */

namespace App\Api\Annotation;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;

/**
 * Annotation class for @MaxDepth().
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class MaxDepth extends \Symfony\Component\Serializer\Annotation\MaxDepth
{
    /**
     * @var int
     */
    private $maxDepth;

    public function __construct(array $data)
    {
        parent::__construct([ 'value' => 1]);

        if (!isset($data['value'])) {
            throw new InvalidArgumentException(sprintf('Parameter of annotation "%s" should be set.', \get_class($this)));
        }

        if (!\is_int($data['value']) || $data['value'] < 0) {
            throw new InvalidArgumentException(sprintf('Parameter of annotation "%s" must be a integer.', \get_class($this)));
        }

        $this->maxDepth = $data['value'];
    }

    public function getMaxDepth()
    {
        return $this->maxDepth;
    }
}
