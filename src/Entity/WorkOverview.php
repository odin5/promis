<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:30:
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Přehled práce - prehled extra nakladu praci
 * @ORM\Entity
 * @ORM\Table(name="work_overview",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UQ_work_overview", columns={"plan_id", "work_id"})}
 * )
 */
class WorkOverview
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
     * (In form as 'Plánovaná cena')
     * @ORM\Column(type="integer")
     */
    private $plannedCost = 0;

    /**
     * (In form as 'Reálná cena')
     * @ORM\Column(type="integer")
     */
    private $realCost = 0;

    /**
     * (In form as 'Plánovaný začátek')
     * @ORM\Column(type="integer")
     */
    private $plannedBegin = 0;

    /**
     * (In form as 'Plánovaný konec')
     * @ORM\Column(type="integer")
     */
    private $plannedEnd = 0;

    /**
     * (In form as 'Začátek')
     * @ORM\Column(type="integer")
     */
    private $begin = 0;

    /**
     * (In form as 'Konec')
     * @ORM\Column(type="integer")
     */
    private $end = 0;

    /**
     * (In form as 'Pozice')
     * @ORM\Column(type="integer")
     */
    private $position = 1;

    public function __toString()
    {
        return "$this->plan $this->work";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlannedCost(): ?int
    {
        return $this->plannedCost;
    }

    public function setPlannedCost(int $plannedCost): self
    {
        $this->plannedCost = $plannedCost;

        return $this;
    }

    public function getRealCost(): ?int
    {
        return $this->realCost;
    }

    public function setRealCost(int $realCost): self
    {
        $this->realCost = $realCost;

        return $this;
    }

    public function getPlannedBegin(): ?int
    {
        return $this->plannedBegin;
    }

    public function setPlannedBegin(int $plannedBegin): self
    {
        $this->plannedBegin = $plannedBegin;

        return $this;
    }

    public function getPlannedEnd(): ?int
    {
        return $this->plannedEnd;
    }

    public function setPlannedEnd(int $plannedEnd): self
    {
        $this->plannedEnd = $plannedEnd;

        return $this;
    }

    public function getBegin(): ?int
    {
        return $this->begin;
    }

    public function setBegin(int $begin): self
    {
        $this->begin = $begin;

        return $this;
    }

    public function getEnd(): ?int
    {
        return $this->end;
    }

    public function setEnd(int $end): self
    {
        $this->end = $end;

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