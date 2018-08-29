<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:30:
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plán práce - Naplanovana prace pro dany projekt/tyden/cetu
 * @ORM\Entity
 * @ORM\Table(name="plan_slot_team",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UQ_plan_slot_team", columns={"plan_id", "turn_id", "team_id", "work_id"})}
 * )
 */
class PlanSlotTeam
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * (In form as 'Plán')
     * @ORM\ManyToOne(targetEntity="Plan")
     */
    private $plan;

    /**
     * (In form as 'Kolo')
     * @ORM\ManyToOne(targetEntity="Turn")
     */
    private $turn;

    /**
     * (In form as 'Tým')
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $team;

    /**
     * (In form as 'Práce')
     * @ORM\ManyToOne(targetEntity="Work")
     */
    private $work;
    /**
     * (In form as 'Počet')
     * @ORM\Column(type="integer")
     */
    private $count = 0;


    public function __toString()
    {
        return "$this->plan, $this->turn: $this->work - $this->team x $this->count";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    public function setPlan(?Plan $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function getTurn(): ?Turn
    {
        return $this->turn;
    }

    public function setTurn(?Turn $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

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