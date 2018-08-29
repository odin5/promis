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
class EventVariantTranslation
{
    use Translation;

    /**
     * (In form as 'Varianta události')
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name = '';

    /**
     * (In form as 'Popis')
     * @ORM\Column(type="text")
     */
    private $description = '';

    /**
     * (In form as 'Řešení')
     * @ORM\Column(type="text")
     */
    private $solution = '';

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

    public function getSolution(): ?string
    {
        return $this->solution;
    }

    public function setSolution(string $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

}