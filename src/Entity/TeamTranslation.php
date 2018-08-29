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
 *     iri="/weathers/translations",
 *     collectionOperations={},
 *     itemOperations={
 *         "get"={ "path"="/weathers/translations/{id}"}
 *     }
 * )
 * @ORM\Entity
 */
class TeamTranslation
{
    use Translation;

    /**
     * (In form as 'Četa' - help 'Název')
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Groups({"Team_read"})
     */
    private $name = '';

    /**
     * (In form as 'Popis')
     * @ORM\Column(type="text")
     * @Groups({"Team_read"})
     */
    private $description = '';

    /**
     * (In form as 'Druh')
     * @ORM\Column(type="string", length=50)
     * @Groups({"Team_read"})
     */
    private $style = '';

    /**
     * (In form as 'Typ')
     * @ORM\Column(type="string", length=50)
     * @Groups({"Team_read"})
     */
    private $type = '';

    /**
     * (In form as 'Velikost')
     * @ORM\Column(type="string", length=50)
     * @Groups({"Team_read"})
     */
    private $size = '';

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

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }
}