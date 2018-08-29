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
 * Práce
 * @ApiResource(
 *     normalizationContext={"groups"={"Work_read"}, "swagger_definition_name"="Work_read"},
 *     denormalizationContext={"groups"={"Work_write"}, "swagger_definition_name"="Work_write"},
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
class Work
{
    use Translatable;

    /**
     * @Assert\Valid;
     * @Groups({"Work_read", "Planning_read"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"Work_read", "Planning_read"})
     */
    private $id;

    /**
     * (In form as 'Projekt')
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @Groups({"Work_read", "Planning_read"})
     */
    private $project;

    /**
     * (In form as 'Náklady')
     * @ORM\Column(type="integer")
     * @Groups({"Work_read", "Planning_read"})
     */
    private $costs = 0;

    /**
     * (In form as 'Max. počet pracovních čet')
     * @ORM\Column(type="integer")
     * @Groups({"Work_read", "Planning_read"})
     */
    private $maxTeams = 0;

    /**
     * (In form as 'Navazující práce') (0 nebo id nasledne prace)
     * @ORM\ManyToOne(targetEntity="Work")
     * @ORM\JoinColumn(name="cumulative_id", referencedColumnName="id", nullable=true)
     * @Groups({"Work_read", "Planning_read"})
     */
    private $cumulative = null;

    /**
     * (In form as 'Barva')
     * @ORM\Column(type="string", length=10)
     * @Groups({"Work_read", "Planning_read"})
     */
    private $color = '#ffffff';

    /**
     * (In form as 'Procenta')
     * @ORM\Column(type="integer")
     * @Groups({"Work_read", "Planning_read"})
     */
    private $percents = 100;

    /**
     * (In form as 'Pozice ve výpisu')
     * @ORM\Column(type="integer")
     * @Groups({"Work_read", "Planning_read"})
     */
    private $position = 1;

    public function __toString()
    {
        return "[". $this->getAbbrev() ."] ". $this->getName();
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

    public function translate($locale = null, $fallbackToDefault = true): WorkTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMaxTeams(): ?int
    {
        return $this->maxTeams;
    }

    public function setMaxTeams(int $maxTeams): self
    {
        $this->maxTeams = $maxTeams;

        return $this;
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

    public function getPercents(): ?int
    {
        return $this->percents;
    }

    public function setPercents(int $percents): self
    {
        $this->percents = $percents;

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

    public function getCumulative(): ?self
    {
        return $this->cumulative;
    }

    public function setCumulative(?self $cumulative): self
    {
        $this->cumulative = $cumulative;

        return $this;
    }

}