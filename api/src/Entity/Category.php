<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

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
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Budget", inversedBy="categories")
     *
     * @var Budget
     */
    protected $budget;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategoryBudgetAtMonth", mappedBy="category")
     *
     * @var Collection|CategoryBudgetAtMonth[]
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
     * @return CategoryBudgetAtMonth[]|Collection
     */
    public function getCategoryBudgetAtMonths()
    {
        return $this->categoryBudgetAtMonths;
    }

    /**
     * @param CategoryBudgetAtMonth[]|Collection $categoryBudgetAtMonths
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
     * @param CategoryBudgetAtMonth $categoryBudgetAtMonth
     */
    public function addCategoryBudgetAtMonth(CategoryBudgetAtMonth $categoryBudgetAtMonth)
    {
        if (!$this->categoryBudgetAtMonths->contains($categoryBudgetAtMonth)) {
            $this->categoryBudgetAtMonths->add($categoryBudgetAtMonth);
            $categoryBudgetAtMonth->setCategory($this);
        }
    }

    /**
     * @param CategoryBudgetAtMonth $categoryBudgetAtMonth
     */
    public function removeCategoryBudgetAtMonth(CategoryBudgetAtMonth $categoryBudgetAtMonth)
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
