<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * Stav financí - historie cash-flow
 * @ORM\Entity
 */
class Balance
{
    use Translatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Turn")
     * @ORM\JoinColumn(name="turn_id", referencedColumnName="id")
     */
    private $turn;

    /**
     * @ORM\ManyToOne(targetEntity="Plan")
     * @ORM\JoinColumn(name="plan_id", referencedColumnName="id")
     */
    private $plan;

    /**
     * @ORM\Column(type="integer")
     */
    private $expenses = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $incomes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $extraExpenses = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $extraIncomes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $credit = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $refunds = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $interest = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $balance = 0;

    public function __toString()
    {
        return "$this->plan - $this->turn";
    }

    public function getDescription()
    {
        return $this->proxyCurrentLocaleTranslation('getDescription');
    }

    public function translate($locale = null, $fallbackToDefault = true): BalanceTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpenses(): ?int
    {
        return $this->expenses;
    }

    public function setExpenses(int $expenses): self
    {
        $this->expenses = $expenses;

        return $this;
    }

    public function getIncomes(): ?int
    {
        return $this->incomes;
    }

    public function setIncomes(int $incomes): self
    {
        $this->incomes = $incomes;

        return $this;
    }

    public function getExtraExpenses(): ?int
    {
        return $this->extraExpenses;
    }

    public function setExtraExpenses(int $extraExpenses): self
    {
        $this->extraExpenses = $extraExpenses;

        return $this;
    }

    public function getExtraIncomes(): ?int
    {
        return $this->extraIncomes;
    }

    public function setExtraIncomes(int $extraIncomes): self
    {
        $this->extraIncomes = $extraIncomes;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(int $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getRefunds(): ?int
    {
        return $this->refunds;
    }

    public function setRefunds(int $refunds): self
    {
        $this->refunds = $refunds;

        return $this;
    }

    public function getInterest(): ?int
    {
        return $this->interest;
    }

    public function setInterest(int $interest): self
    {
        $this->interest = $interest;

        return $this;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

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

    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    public function setPlan(?Plan $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

}