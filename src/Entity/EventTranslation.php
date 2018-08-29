<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 16:49
 */

namespace App\Entity;


use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class EventTranslation
{
    use Translation;

    /**
     * (In form as 'Jméno')
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name = '';

    /**
     * (In form as 'Popis')
     * @ORM\Column(type="text", nullable=true)
     */
    private $description = null;

    /**
     * (In form as 'Poznámky')
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes = null;

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

}