<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vnější vliv
 * @ApiResource(
 *     normalizationContext={"groups"={"Weather_read"}, "swagger_definition_name"="Weather_read"},
 *     denormalizationContext={"groups"={"Weather_write"}, "swagger_definition_name"="Weather_write"},
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="(is_granted('ROLE_ADMIN') or object.project in user.allowedProjects)"},
 *         "put"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 * @ORM\Entity
 */
class Weather
{
    use Translatable;

    /**
     * @Assert\Valid;
     * @Groups({"Weather_read", "Planning_read"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"Weather_read", "Planning_read"})
     */
    private $id;

    /**
     * (In form as 'Projekt')
     * @ORM\ManyToOne(targetEntity="Project")
     * @Groups({"Weather_read", "Planning_read"})
     */
    private $project;

    /**
     * (In form as 'Barva')
     * @ORM\Column(type="string")
     * @Groups({"Weather_read", "Planning_read"})
     */
    private $color = 0;

    public function __toString()
    {
        return $this->getName();
    }

    public function getName()
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function getDescription()
    {
        return $this->proxyCurrentLocaleTranslation('getDescription');
    }

    public function translate($locale = null, $fallbackToDefault = true): WeatherTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }


}