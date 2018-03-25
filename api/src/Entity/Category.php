<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Money;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr")
 * @ORM\DiscriminatorMap({"dc" = "DefaultCategory", "mc" = "MoneyCategory", "c" = "Category"})
 * @SWG\Definition()
 */
class Category
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"category_list"})
     *
     * @SWG\Property()
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"category_list"})
     *
     * @SWG\Property()
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\Embedded(class="Money\Money")
     *
     * @Groups({"category_list"})
     *
     * @SWG\Property(property="money", ref="#/definitions/Money")
     *
     * @var Money
     */
    protected $money;

    /**
     * @ORM\OneToMany(targetEntity="MoneyAtMonth", mappedBy="category", cascade={"persist"})
     *
     * @var Collection|MoneyAtMonth[]
     */
    protected $moneyAtMonth;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="category")
     *
     * @var Collection|Transaction[]
     */
    protected $transactions;

    /**
     * Will be overridden by the derived classes.
     *
     * @var Budget
     */
    protected $budget;

    public function __construct()
    {
        $this->moneyAtMonth = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }

    /**
     * @param Money $money
     */
    public function setMoney(Money $money): void
    {
        $this->money = $money;
    }

    /**
     * @param Money $money
     */
    public function addMoney(Money $money): void {
        $this->money = $this->money->add($money);
    }

    /**
     * @param Money $money
     */
    public function subtractMoney(Money $money): void {
        $this->money = $this->money->subtract($money);
    }

    /**
     * @return MoneyAtMonth[]|Collection
     */
    public function getMoneyAtMonth()
    {
        return $this->moneyAtMonth;
    }

    /**
     * @param MoneyAtMonth[]|Collection $moneyAtMonth
     */
    public function setMoneyAtMonth($moneyAtMonth): void
    {
        $this->moneyAtMonth = $moneyAtMonth;
    }

    /**
     * @return Transaction[]|Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param Transaction[]|Collection $transactions
     */
    public function setTransactions($transactions): void
    {
        $this->transactions = $transactions;
    }

    /**
     * @return Budget
     */
    public function getBudget(): Budget
    {
        return $this->budget;
    }

    /**
     * @param Budget $budget
     */
    public function setBudget(Budget $budget): void
    {
        $this->budget = $budget;
    }

    /**
     * @param MoneyAtMonth $moneyAtMonth
     */
    public function addMoneyAtMonth(MoneyAtMonth $moneyAtMonth)
    {
        if (!$this->moneyAtMonth->contains($moneyAtMonth)) {
            $this->moneyAtMonth->add($moneyAtMonth);
            $moneyAtMonth->setCategory($this);
        }
    }

    /**
     * @param MoneyAtMonth $moneyAtMonth
     */
    public function removeMoneyAtMonth(MoneyAtMonth $moneyAtMonth)
    {
        if ($this->moneyAtMonth->contains($moneyAtMonth)) {
            $this->moneyAtMonth->removeElement($moneyAtMonth);
            $moneyAtMonth->setCategory(null);
        }
    }

    /**
     * @param Transaction $transaction
     */
    public function addTransaction(Transaction $transaction)
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setCategory($this);
        }
    }

    /**
     * @param Transaction $transaction
     */
    public function removeTransaction(Transaction $transaction)
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            $transaction->setCategory(null);
        }
    }

}
