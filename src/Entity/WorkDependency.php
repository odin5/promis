<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Závislost práce - pocasi, ktere je zakazane pro danou praci
 * @ORM\Entity
 */
class WorkDependency
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Work")
     * @ORM\JoinColumn(name="previous_id", referencedColumnName="id")
     */
    private $previous;

    /**
     * @ORM\ManyToOne(targetEntity="Work")
     * @ORM\JoinColumn(name="next_id", referencedColumnName="id")
     */
    private $next;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMutual = false;

    public function __toString()
    {
        return $this->getPrevious() .' -> '. $this->getNext();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsMutual(): ?bool
    {
        return $this->isMutual;
    }

    public function setIsMutual(bool $isMutual): self
    {
        $this->isMutual = $isMutual;

        return $this;
    }

    public function getPrevious(): ?Work
    {
        return $this->previous;
    }

    public function setPrevious(?Work $previous): self
    {
        $this->previous = $previous;

        return $this;
    }

    public function getNext(): ?Work
    {
        return $this->next;
    }

    public function setNext(?Work $next): self
    {
        $this->next = $next;

        return $this;
    }

}