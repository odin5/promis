<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * Kumulace čet
 * @ORM\Entity
 */
class TeamCummulation
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
     * (In form as 'Maximální počet')
     * @ORM\Column(type="integer")
     */
    private $max_count = 0;

    public function __toString()
    {
        return (string)$this->getName();
    }

    public function getName()
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function translate($locale = null, $fallbackToDefault = true): TeamCummulationTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxCount(): ?int
    {
        return $this->max_count;
    }

    public function setMaxCount(int $max_count): self
    {
        $this->max_count = $max_count;

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