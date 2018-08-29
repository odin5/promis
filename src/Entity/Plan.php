<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:30:
 */

namespace App\Entity;

use App\ClassTrait\TranslatableCustomizationTrait;
use ApiPlatform\Core\Annotation\ApiResource;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plán
 * @ApiResource(
 *     normalizationContext={"groups"={"Plan_read"}, "swagger_definition_name"="Plan_read"},
 *     denormalizationContext={"groups"={"Plan_write"}, "swagger_definition_name"="Plan_write"},
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('play', object) or is_granted('view', object) or is_granted('ROLE_ADMIN')"},
 *         "post"={"access_control"="is_granted('play', object) or is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('play', object) or is_granted('ROLE_ADMIN')"},
 *         "put"={"access_control"="is_granted('play', object) or is_granted('ROLE_ADMIN')"},
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PlanRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Plan
{
    use Translatable, TranslatableCustomizationTrait;

    /**
     * @Assert\Valid;
     * @Groups({"Plan_read", "Plan_write"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"Plan_read", "Planning_read"})
     */
    private $id;

    /**
     * (In form as 'Herní projekt')
     * @ORM\ManyToOne(targetEntity="PlayersProject")
     * @ORM\JoinColumn(name="pproject_id", referencedColumnName="id")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     * @MaxDepth(1)
     */
    private $playersProject;

    /**
     * (In form as 'Herní plán')
     * @ORM\Column(type="boolean")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $isInGame = false;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $finish = 0;

    /**
     * (In form as 'Aktuální kolo')
     * @ORM\ManyToOne(targetEntity="Turn")
     * @ORM\JoinColumn(name="turn_id", referencedColumnName="id", nullable=true)
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $currentTurn = null;

    /**
     * (In form as 'Stav účtu')
     * @ORM\Column(type="integer")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $isMutual = 0;

    /**
     * (In form as 'Vnější vliv')
     * @ORM\ManyToOne(targetEntity="Weather")
     * @ORM\JoinColumn(name="weather_id", referencedColumnName="id", nullable=true)
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $weather = null;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $result = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $image = 0;

    /**
     * blokovano - musi se nejprve vyresit udalost
     * @ORM\Column(type="integer")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $blocked = false;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $timeLimit = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $turnsLost = 0;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $isHidden = false;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $isOld = false;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Plan_read", "admin:write", "Planning_read"})
     */
    private $extra = 0;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"Plan_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"Plan_read"})
     */
    private $changedAt;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setChangedAt()
    {
        $this->changedAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->getName() ." ($this->id)";
    }

    /**
     * @Groups({"Plan_read", "Planning_read"})
     */
    public function getName()
    {
        return $this->translate()->getName();
    }

    public function translate($locale = null, $fallbackToDefault = true): PlanTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsInGame(): ?bool
    {
        return $this->isInGame;
    }

    public function setIsInGame(bool $isInGame): self
    {
        $this->isInGame = $isInGame;

        return $this;
    }

    public function getFinish(): ?int
    {
        return $this->finish;
    }

    public function setFinish(int $finish): self
    {
        $this->finish = $finish;

        return $this;
    }

    public function getIsMutual(): ?int
    {
        return $this->isMutual;
    }

    public function setIsMutual(int $isMutual): self
    {
        $this->isMutual = $isMutual;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getImage(): ?int
    {
        return $this->image;
    }

    public function setImage(int $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBlocked(): ?int
    {
        return $this->blocked;
    }

    public function setBlocked(int $blocked): self
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function getTimeLimit(): ?int
    {
        return $this->timeLimit;
    }

    public function setTimeLimit(int $timeLimit): self
    {
        $this->timeLimit = $timeLimit;

        return $this;
    }

    public function getTurnsLost(): ?int
    {
        return $this->turnsLost;
    }

    public function setTurnsLost(int $turnsLost): self
    {
        $this->turnsLost = $turnsLost;

        return $this;
    }

    public function getIsHidden(): ?bool
    {
        return $this->isHidden;
    }

    public function setIsHidden(bool $isHidden): self
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    public function getIsOld(): ?bool
    {
        return $this->isOld;
    }

    public function setIsOld(bool $isOld): self
    {
        $this->isOld = $isOld;

        return $this;
    }

    public function getExtra(): ?int
    {
        return $this->extra;
    }

    public function setExtra(int $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    public function getPlayersProject(): ?PlayersProject
    {
        return $this->playersProject;
    }

    public function setPlayersProject(?PlayersProject $playersProject): self
    {
        $this->playersProject = $playersProject;

        return $this;
    }

    public function getCurrentTurn(): ?Turn
    {
        return $this->currentTurn;
    }

    public function setCurrentTurn(?Turn $currentTurn): self
    {
        $this->currentTurn = $currentTurn;

        return $this;
    }

    public function getWeather(): ?weather
    {
        return $this->weather;
    }

    public function setWeather(?weather $weather): self
    {
        $this->weather = $weather;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getChangedAt(): ?\DateTimeInterface
    {
        return $this->changedAt;
    }

}