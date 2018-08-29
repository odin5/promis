<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 25.07.2018 16:13:
 */

namespace App\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class SchoolTranslation
{
    use Translation;

    /**
     * (In form as 'Název')
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

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