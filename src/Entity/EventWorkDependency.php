<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Závislost události na práci - podminky vazane na stav praci
 * @ORM\Entity
 */
class EventWorkDependency
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * (In form as 'Událost')
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * (In form as 'Práce')
     * @ORM\ManyToOne(targetEntity="Work")
     * @ORM\JoinColumn(name="work_id", referencedColumnName="id")
     */
    private $work;

    /**
     * (In form as 'Práce probíhá') prace ne/probiha
     * @ORM\Column(type="boolean")
     */
    private $isRunning = false;

    /**
     * (In form as 'Stav práce' - help 'v procentech') stav prace v procentech
     * @ORM\Column(type="integer")
     */
    private $state = 0;

    public function __toString()
    {
        return "$this->event depends on $this->work, running: $this->running, state: $this->state";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsRunning(): ?bool
    {
        return $this->isRunning;
    }

    public function setIsRunning(bool $isRunning): self
    {
        $this->isRunning = $isRunning;

        return $this;
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

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