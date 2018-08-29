<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pracovní omezení - pocasi, ktere je zakazane pro danou praci
 * @ORM\Entity
 */
class WorkWeather
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * (In form as 'Práce')
     * @ORM\ManyToOne(targetEntity="Work")
     * @ORM\JoinColumn(name="work_id", referencedColumnName="id")
     */
    private $work;

    /**
     * (In form as 'Vnější vliv')
     * @ORM\ManyToOne(targetEntity="Weather")
     * @ORM\JoinColumn(name="wather_id", referencedColumnName="id")
     */
    private $weather;

    public function __toString()
    {
        return (string)$this->getWeather();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getWeather(): ?Weather
    {
        return $this->weather;
    }

    public function setWeather(?Weather $weather): self
    {
        $this->weather = $weather;

        return $this;
    }

}