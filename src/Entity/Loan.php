<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Půjčka
 * @ORM\Entity
 * @ORM\Table(name="loan",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UQ_loan", columns={"plan_id", "turn_id", "is_repayment"})}
 * )
 */
class Loan
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * (In form as 'Půjčka')
     * @ORM\ManyToOne(targetEntity="Plan")
     * @ORM\JoinColumn(name="plan_id", referencedColumnName="id")
     */
    private $plan;

    /**
     * (In form as 'Kolo')
     * @ORM\ManyToOne(targetEntity="Turn")
     * @ORM\JoinColumn(name="turn_id", referencedColumnName="id")
     */
    private $turn;

    /**
     * (In form as 'Částka')
     * @ORM\Column(type="integer")
     */
    private $amount = 0;

    /**
     * Is it another loan or actually a repayment (In form as 'Splátka')
     * @ORM\Column(type="boolean")
     */
    private $isRepayment = false;

    public function __toString()
    {
        return $this->plan." - $this->turn $this->amount";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIsRepayment(): ?bool
    {
        return $this->isRepayment;
    }

    public function setIsRepayment(bool $isRepayment): self
    {
        $this->isRepayment = $isRepayment;

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

    public function getTurn(): ?Turn
    {
        return $this->turn;
    }

    public function setTurn(?Turn $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

}