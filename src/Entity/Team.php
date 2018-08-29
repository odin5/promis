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
 * Četa
 * @ApiResource(
 *     normalizationContext={"groups"={"Team_read"}, "swagger_definition_name"="Team_read"},
 *     denormalizationContext={"groups"={"Team_write"}, "swagger_definition_name"="Team_write"},
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
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 */
class Team
{
    use Translatable;

    /**
     * @Assert\Valid;
     * @Groups({"Team_read", "Planning_read"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $id;

    /**
     * (In form as 'Projekt')
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $project;

    /**
     * (In form as 'Výkon')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $productivity = 0;

    /**
     * (In form as 'Náklady')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $costs = 0;

    /**
     * (In form as 'Spolehlivost')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $reliability = 0;

    /**
     * (In form as 'Důsledek nesp. v % výkonu')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $reliabilityProdLoss = 0;

    /**
     * (In form as 'Důsledek nesp. v % nákladů')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $reliabilityCostsLoss = 0;

    /**
     * (In form as 'Pokuta za odvolání čety')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $penaltyOff = 0;

    /**
     * (In form as 'Pokuta za přesun čety')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $penaltyMove = 0;

    /**
     * (In form as 'Max. počet čet v jednom kole')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $maxCount = 0;

    /**
     * (In form as 'Kumulace')
     * @ORM\ManyToOne(targetEntity="TeamCummulation")
     * @ORM\JoinColumn(name="cumulative_id", referencedColumnName="id", nullable=true)
     * @Groups({"Team_read", "Planning_read"})
     */
    private $cumulative;

    /**
     * (In form as 'Ikona')
     * @ORM\ManyToOne(targetEntity="Icon")
     * @ORM\JoinColumn(name="cumulative_id", referencedColumnName="id")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $icon;

    /**
     * (In form as 'Práce')
     * @ORM\ManyToOne(targetEntity="Work")
     * @ORM\JoinColumn(name="cumulative_id", referencedColumnName="id")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $work;

    /**
     * (In form as 'Pozice')
     * @ORM\Column(type="integer")
     * @Groups({"Team_read", "Planning_read"})
     */
    private $position = 1;

    public function __toString()
    {
        return (string) $this->getName();
    }

    public function getName()
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function getDescription()
    {
        return $this->proxyCurrentLocaleTranslation('getDescription');
    }

    public function getAbbrev()
    {
        return $this->proxyCurrentLocaleTranslation('getAbbrev');
    }

    public function translate($locale = null, $fallbackToDefault = true): TeamTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductivity(): ?int
    {
        return $this->productivity;
    }

    public function setProductivity(int $productivity): self
    {
        $this->productivity = $productivity;

        return $this;
    }

    public function getCosts(): ?int
    {
        return $this->costs;
    }

    public function setCosts(int $costs): self
    {
        $this->costs = $costs;

        return $this;
    }

    public function getReliability(): ?int
    {
        return $this->reliability;
    }

    public function setReliability(int $reliability): self
    {
        $this->reliability = $reliability;

        return $this;
    }

    public function getReliabilityProdLoss(): ?int
    {
        return $this->reliabilityProdLoss;
    }

    public function setReliabilityProdLoss(int $reliabilityProdLoss): self
    {
        $this->reliabilityProdLoss = $reliabilityProdLoss;

        return $this;
    }

    public function getReliabilityCostsLoss(): ?int
    {
        return $this->reliabilityCostsLoss;
    }

    public function setReliabilityCostsLoss(int $reliabilityCostsLoss): self
    {
        $this->reliabilityCostsLoss = $reliabilityCostsLoss;

        return $this;
    }

    public function getPenaltyOff(): ?int
    {
        return $this->penaltyOff;
    }

    public function setPenaltyOff(int $penaltyOff): self
    {
        $this->penaltyOff = $penaltyOff;

        return $this;
    }

    public function getPenaltyMove(): ?int
    {
        return $this->penaltyMove;
    }

    public function setPenaltyMove(int $penaltyMove): self
    {
        $this->penaltyMove = $penaltyMove;

        return $this;
    }

    public function getMaxCount(): ?int
    {
        return $this->maxCount;
    }

    public function setMaxCount(int $maxCount): self
    {
        $this->maxCount = $maxCount;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

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

    public function getCumulative(): ?TeamCummulation
    {
        return $this->cumulative;
    }

    public function setCumulative(?TeamCummulation $cumulative): self
    {
        $this->cumulative = $cumulative;

        return $this;
    }

    public function getIcon(): ?Icon
    {
        return $this->icon;
    }

    public function setIcon(?Icon $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getWork(): ?Work
    {
        return $this->work;
    }

    public function setWork(?Work $work): self
    {
        $this->work = $work;

        return $this;
    }

}