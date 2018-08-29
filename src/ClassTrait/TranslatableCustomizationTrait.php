<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 27.08.2018 13:41
 */
namespace App\ClassTrait;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait TranslatableCustomizationTrait
{
    /**
     * @Assert\Valid;
     * @ApiProperty()
     * @Groups("api")
     */
    protected $translations;
}