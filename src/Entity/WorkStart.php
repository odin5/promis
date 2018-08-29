<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:30:
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Začátek práce - pocatecni tyden dane prace
 * @ORM\Entity
 * @ORM\Table(name="work_start",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UQ_work_start", columns={"plan_id", "work_id"})}
 * )
 */
class WorkStart
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
     * (In form as 'Práce')
     * @ORM\ManyToOne(targetEntity="Work")
     */
    private $work;

    /**
     * (In form as 'Kolo')
     * @ORM\ManyToOne(targetEntity="Turn")
     */
    private $turn;


    public function __toString()
    {
        return "WorkStart: $this->plan, $this->work, $this->turn";
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getWork(): ?Work
    {
        return $this->work;
    }

    public function setWork(?Work $work): self
    {
        $this->work = $work;

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
}