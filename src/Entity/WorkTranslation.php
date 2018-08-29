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
 *     iri="/works/translations",
 *     collectionOperations={},
 *     itemOperations={
 *         "get"={ "path"="/works/translations/{id}"}
 *     }
 * )
 * @ORM\Entity
 */
class WorkTranslation
{
    use Translation;

    /**
     * (In form as 'Jméno')
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Groups({"Work_read"})
     */
    private $name = '';

    /**
     * (In form as 'Popis')
     * @ORM\Column(type="text")
     * @Groups({"Work_read"})
     */
    private $description = '';

    /**
     * (In form as 'Zkratka')
     * @ORM\Column(type="string", length=5)
     * @Groups({"Work_read"})
     */
    private $abbrev = '';

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAbbrev(): ?string
    {
        return $this->abbrev;
    }

    public function setAbbrev(string $abbrev): self
    {
        $this->abbrev = $abbrev;

        return $this;
    }
}