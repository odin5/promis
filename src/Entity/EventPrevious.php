<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:30:
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Předchozí událost - udalosti, ktere museji/nesmeji predchazet
 * @ORM\Entity
 * @ORM\Table(name="event_previous",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UQ_event_previous", columns={"previous_id", "current_id"})}
 * )
 */
class EventPrevious
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="EventVariant")
     */
    private $previous;

    /**
     * (In form as 'Aktuální událost')
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $current;
    /**
     * (In form as 'Musí/nesmí předcházet')
     * @ORM\Column(type="integer")
     */
    private $isNeeded = 0;
    /**
     * (In form as 'Kolo události')
     * @ORM\Column(type="integer")
     */
    private $time = 0;


    public function __toString()
    {
        return "$this->previous -> $this->current";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsNeeded(): ?int
    {
        return $this->isNeeded;
    }

    public function setIsNeeded(int $isNeeded): self
    {
        $this->isNeeded = $isNeeded;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getPrevious(): ?EventVariant
    {
        return $this->previous;
    }

    public function setPrevious(?EventVariant $previous): self
    {
        $this->previous = $previous;

        return $this;
    }

    public function getCurrent(): ?Event
    {
        return $this->current;
    }

    public function setCurrent(?Event $current): self
    {
        $this->current = $current;

        return $this;
    }
}