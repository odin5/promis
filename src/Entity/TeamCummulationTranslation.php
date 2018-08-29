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
class TeamCummulationTranslation
{
    use Translation;

    /**
     * (In form as 'Jméno')
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
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