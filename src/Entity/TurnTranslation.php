<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 16:49
 */

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     iri="/turns/translations",
 *     collectionOperations={},
 *     itemOperations={
 *         "get"={ "path"="/works/translations/{id}"}
 *     }
 * )
 * @ORM\Entity
 */
class TurnTranslation
{
    use Translation;

    /**
     * (In form as 'Jméno')
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Groups({"Turn_read"})
     */
    private $name = '';

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

}