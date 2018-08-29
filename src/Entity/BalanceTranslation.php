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
class BalanceTranslation
{
    use Translation;

    /**
     * (In form as 'Jméno')
     * @ORM\Column(type="string", length=100)
     */
    private $description = '';

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}