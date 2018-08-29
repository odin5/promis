<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * Událost - popis soku
 * @ORM\Entity
 */
class Event
{
    use Translatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * (In form as 'Projekt')
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * (In form as 'Kolo')
     * @ORM\Column(type="integer")
     */
    private $turn = 0;

    /**
     * (In form as 'Šance vzniku')
     * @ORM\Column(type="integer")
     */
    private $chance = 100;

    /**
     * (In form as 'Priorita')
     * @ORM\Column(type="integer")
     */
    private $priority = 100;

    public function __toString()
    {
        return (string)$this->getName();
    }

    public function getName()
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function translate($locale = null, $fallbackToDefault = true): EventTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    public function getChance(): ?int
    {
        return $this->chance;
    }

    public function setChance(int $chance): self
    {
        $this->chance = $chance;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

}