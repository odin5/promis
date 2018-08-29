<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 16:49
 */

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Hráčův projekt
 * @ApiResource(
 *     normalizationContext={"groups"={"PlayersProject_read"}, "swagger_definition_name"="PlayersProject_read"},
 *     denormalizationContext={"groups"={"PlayersProject_write"}, "swagger_definition_name"="PlayersProject_write"},
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('play', object) or is_granted('view', object) or is_granted('ROLE_ADMIN')"},
 *         "post"={"access_control"="is_granted('play', object) or is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('play', object) or is_granted('ROLE_ADMIN')"},
 *         "put"={"access_control"="is_granted('play', object) or is_granted('ROLE_ADMIN')"},
 *     },
 * )
 * @ORM\Entity
 */
class PlayersProject
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $id;

    /**
     * (In form as 'Uživatel')
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $player;

    /**
     * (In form as 'Projekt')
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $project;

    /**
     * (In form as 'Pokusy' - help 'Kolikrát má hráč projekt odehrát')
     * @ORM\Column(type="integer")
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $playable = 1;

    /**
     * (In form as 'Odehráno' - help 'Kolikrát již odehráno')
     * @ORM\Column(type="integer")
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $played = 0;

    /**
     * (In form as 'Poslední plán' - help 'Poslední hraný projekt')
     * @ORM\ManyToOne(targetEntity="Plan")
     * @ORM\JoinColumn(name="last_plan_id", referencedColumnName="id", nullable=true)
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $lastPlan = null;

    /**
     * (In form as 'Plánování')
     * @ORM\Column(type="boolean")
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $isPlanning = true;

    /**
     * (In form as 'Projekt úspěšně ukončen')
     * @ORM\Column(type="boolean")
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $isSuccess = false;

    /**
     * (In form as 'Projekt byl alespoň jednou úspěšně zvalidován')
     * @ORM\Column(type="boolean")
     * @Groups({"PlayersProject_read", "Plan_read"})
     */
    private $hasSuccessfulPlan = false;

    public function __construct(Project $project, User $player)
    {
        $this->project = $project;
        $this->player = $player;
        $this->playable = $project->getMultipleGamePlan();
    }

    public function __toString()
    {
        return "$this->player: $this->project";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayable(): ?int
    {
        return $this->playable;
    }

    public function setPlayable(int $playable): self
    {
        $this->playable = $playable;

        return $this;
    }

    public function getPlayed(): ?int
    {
        return $this->played;
    }

    public function setPlayed(int $played): self
    {
        $this->played = $played;

        return $this;
    }

    public function getIsPlanning(): ?bool
    {
        return $this->isPlanning;
    }

    public function setIsPlanning(bool $isPlanning): self
    {
        $this->isPlanning = $isPlanning;

        return $this;
    }

    public function getIsSuccess(): ?bool
    {
        return $this->isSuccess;
    }

    public function setIsSuccess(bool $isSuccess): self
    {
        $this->isSuccess = $isSuccess;

        return $this;
    }

    public function getHasSuccessfulPlan(): ?bool
    {
        return $this->hasSuccessfulPlan;
    }

    public function setHasSuccessfulPlan(bool $hasSuccessfulPlan): self
    {
        $this->hasSuccessfulPlan = $hasSuccessfulPlan;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

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

    public function getLastPlan(): ?Plan
    {
        return $this->lastPlan;
    }

    public function setLastPlan(?Plan $lastPlan): self
    {
        $this->lastPlan = $lastPlan;

        return $this;
    }

}