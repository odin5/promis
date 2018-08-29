<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * Varianta události
 * @ORM\Entity
 */
class EventVariant
{
    use Translatable;

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
     * (In form as 'Následující událost')
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="next_id", referencedColumnName="id", nullable=true)
     */
    private $next = null;

    /**
     * (In form as 'Práce')
     * @ORM\ManyToOne(targetEntity="Work")
     * @ORM\JoinColumn(name="work_id", referencedColumnName="id", nullable=true)
     */
    private $work = null;

    /**
     * (In form as 'Vliv na stav práce')
     * @ORM\Column(type="integer")
     */
    private $productivity = 0;

    /**
     * (In form as 'Vliv na náklady')
     * @ORM\Column(type="integer")
     */
    private $costs = 0;

    /**
     * (In form as 'Vliv na image')
     * @ORM\Column(type="integer")
     */
    private $image = 0;

    /**
     * (In form as 'Časová blokace') blokovani casu
     * @ORM\Column(type="integer")
     */
    private $turns = 0;

    public function __toString()
    {
        return (string)$this->getName();
    }

    public function getName()
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function translate($locale = null, $fallbackToDefault = true): EventVariantTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductivity(): ?int
    {
        return $this->productivity;
    }

    public function setProductivity(int $productivity): self
    {
        $this->productivity = $productivity;

        return $this;
    }

    public function getCosts(): ?int
    {
        return $this->costs;
    }

    public function setCosts(int $costs): self
    {
        $this->costs = $costs;

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

    public function getTurns(): ?int
    {
        return $this->turns;
    }

    public function setTurns(int $turns): self
    {
        $this->turns = $turns;

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

    public function getNext(): ?Event
    {
        return $this->next;
    }

    public function setNext(?Event $next): self
    {
        $this->next = $next;

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