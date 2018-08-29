<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:30:
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stav práce - rozpracovanost praci
 * @ORM\Entity
 * @ORM\Table(name="work_progress",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UQ_work_progress", columns={"plan_id", "work_id"})}
 * )
 */
class WorkProgress
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
     * (In form as 'Stav')
     * @ORM\Column(type="integer")
     */
    private $state = 0;

    public function __toString()
    {
        return "WP: ($this->plan, $this->work) $this->state";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

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