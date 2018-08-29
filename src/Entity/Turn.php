<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Kolo - popis kola
 * @ApiResource(
 *     normalizationContext={"groups"={"Turn_read"}, "swagger_definition_name"="Turn_read"},
 *     denormalizationContext={"groups"={"Turn_write"}, "swagger_definition_name"="Turn_write"},
 *     attributes={"order"={"position","id"}},
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
class Turn
{
    use Translatable;

    /**
     * @Assert\Valid;
     * @Groups({"Turn_read", "Planning_read"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"Turn_read", "Planning_read"})
     */
    private $id;

    /**
     * (In form as 'Projekt')
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @Groups({"Turn_read", "Planning_read"})
     */
    private $project;

    /**
     * (In form as 'Číslo')
     * @ORM\Column(type="integer")
     */
    private $number = 0;

    /**
     * (In form as 'Vnější vliv' - help 'např. počasí')
     * @ORM\ManyToOne(targetEntity="Weather")
     * @ORM\JoinColumn(name="weather_id", referencedColumnName="id")
     */
    private $weather;

    // pravdepodbnost, ze se zmeni pocasi a kam
    /**
     * (In form as 'Šance změny na nový stav vnějšího vlivu' - help '0-100')
     * @ORM\Column(type="integer")
     */
    private $chance = 0;

    /**
     * (In form as 'Nový stav' - help 'Může se změnit na')
     * @ORM\ManyToOne(targetEntity="Weather")
     * @ORM\JoinColumn(name="weather_id", referencedColumnName="id")
     */
    private $toWeather;

    /**
     * (In form as 'Stálost' - help 'Nelze pravděpodobnostně změnit')
     * @ORM\Column(type="boolean")
     */
    private $isPermanent = false;

    /**
     * (In form as 'Částka')
     * @ORM\Column(type="integer")
     */
    private $amount = 0;

    public function __toString()
    {
        return (string) ($this->getName() ? $this->getName() : $this->number);
    }

    public function getName()
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function translate($locale = null, $fallbackToDefault = true): TurnTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getChance(): ?int
    {
        return $this->chance;
    }

    public function setChance(int $chance): self
    {
        $this->chance = $chance;

        return $this;
    }

    public function getIsPermanent(): ?bool
    {
        return $this->isPermanent;
    }

    public function setIsPermanent(bool $isPermanent): self
    {
        $this->isPermanent = $isPermanent;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    public function getWeather(): ?Weather
    {
        return $this->weather;
    }

    public function setWeather(?Weather $weather): self
    {
        $this->weather = $weather;

        return $this;
    }

    public function getToWeather(): ?Weather
    {
        return $this->toWeather;
    }

    public function setToWeather(?Weather $toWeather): self
    {
        $this->toWeather = $toWeather;

        return $this;
    }

}