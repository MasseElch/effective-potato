<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Money;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
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
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"category_list"})
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\Embedded(class="Money\Money")
     *
     * @Groups({"category_list"})
     *
     * @var Money
     */
    protected $money;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Budget", inversedBy="categories")
     *
     * @var Budget
     */
    protected $budget;

    /**
     * @ORM\OneToMany(targetEntity="CategoryMoneyAtMonth", mappedBy="category")
     *
     * @var Collection|CategoryMoneyAtMonth[]
     */
    protected $categoryBudgetAtMonths;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="category")
     *
     * @var Collection|Transaction[]
     */
    protected $transactions;

    public function __construct()
    {
        $this->categoryBudgetAtMonths = new ArrayCollection();
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
     * @return Budget
     */
    public function getBudget(): ?Budget
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
     * @return CategoryMoneyAtMonth[]|Collection
     */
    public function getCategoryBudgetAtMonths()
    {
        return $this->categoryBudgetAtMonths;
    }

    /**
     * @param CategoryMoneyAtMonth[]|Collection $categoryBudgetAtMonths
     */
    public function setCategoryBudgetAtMonths($categoryBudgetAtMonths): void
    {
        $this->categoryBudgetAtMonths = $categoryBudgetAtMonths;
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
     * @param CategoryMoneyAtMonth $categoryBudgetAtMonth
     */
    public function addCategoryBudgetAtMonth(CategoryMoneyAtMonth $categoryBudgetAtMonth)
    {
        if (!$this->categoryBudgetAtMonths->contains($categoryBudgetAtMonth)) {
            $this->categoryBudgetAtMonths->add($categoryBudgetAtMonth);
            $categoryBudgetAtMonth->setCategory($this);
        }
    }

    /**
     * @param CategoryMoneyAtMonth $categoryBudgetAtMonth
     */
    public function removeCategoryBudgetAtMonth(CategoryMoneyAtMonth $categoryBudgetAtMonth)
    {
        if ($this->categoryBudgetAtMonths->contains($categoryBudgetAtMonth)) {
            $this->categoryBudgetAtMonths->removeElement($categoryBudgetAtMonth);
            $categoryBudgetAtMonth->setCategory(null);
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
