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
class WeatherTranslation
{
    use Translation;

    /**
     * (In form as 'Jméno')
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Groups({"Weather_read"})
     */
    private $name = '';

    /**
     * (In form as 'Popis')
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Groups({"Weather_read"})
     */
    private $description = '';

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


}