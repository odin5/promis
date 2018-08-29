<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:30:
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historie práce - historie praci
 * @ORM\Entity
 * @ORM\Table(name="work_history",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UQ_work_history", columns={"plan_id", "work_id"})}
 * )
 */
class WorkHistory
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
     * (In form as 'Začátek')
     * @ORM\ManyToOne(targetEntity="Turn")
     * @ORM\JoinColumn(name="begin_id", referencedColumnName="id")
     */
    private $begin;

    /**
     * (In form as 'Konec')
     * @ORM\ManyToOne(targetEntity="Turn")
     * @ORM\JoinColumn(name="end_id", referencedColumnName="id", nullable=true)
     */
    private $end = null;

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

    public function getBegin(): ?Turn
    {
        return $this->begin;
    }

    public function setBegin(?Turn $begin): self
    {
        $this->begin = $begin;

        return $this;
    }

    public function getEnd(): ?Turn
    {
        return $this->end;
    }

    public function setEnd(?Turn $end): self
    {
        $this->end = $end;

        return $this;
    }
}