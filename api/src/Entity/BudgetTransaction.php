<?php

namespace App\Entity;

use Cake\Chronos\Chronos;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetTransactionRepository")
 */
class BudgetTransaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Embedded(class="Money\Money")
     *
     * @var Money
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var Chronos
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="CategoryMoneyAtMonth", inversedBy="outflows")
     *
     * @var CategoryMoneyAtMonth
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity="CategoryMoneyAtMonth", inversedBy="inflows")
     *
     * @var CategoryMoneyAtMonth
     */
    private $target;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @param Money $amount
     */
    public function setAmount(Money $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return Chronos
     */
    public function getDate(): Chronos
    {
        return $this->date;
    }

    /**
     * @param Chronos $date
     */
    public function setDate(Chronos $date): void
    {
        $this->date = $date;
    }

    /**
     * @return CategoryMoneyAtMonth
     */
    public function getSource(): CategoryMoneyAtMonth
    {
        return $this->source;
    }

    /**
     * @param CategoryMoneyAtMonth $source
     */
    public function setSource(CategoryMoneyAtMonth $source): void
    {
        $this->source = $source;
    }

    /**
     * @return CategoryMoneyAtMonth
     */
    public function getTarget(): CategoryMoneyAtMonth
    {
        return $this->target;
    }

    /**
     * @param CategoryMoneyAtMonth $target
     */
    public function setTarget(CategoryMoneyAtMonth $target): void
    {
        $this->target = $target;
    }

}
