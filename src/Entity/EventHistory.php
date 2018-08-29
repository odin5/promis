<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:30:
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historie události - historie udalosti
 * @ORM\Entity
 * @ORM\Table(name="event_history",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UQ_event_history", columns={"plan_id", "event_id"})}
 * )
 */
class EventHistory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Plan")
     */
    private $plan;

    /**
     * @ORM\ManyToOne(targetEntity="Turn")
     */
    private $turn;

    /**
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $event;

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

    public function getTurn(): ?Turn
    {
        return $this->turn;
    }

    public function setTurn(?Turn $turn): self
    {
        $this->turn = $turn;

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

}