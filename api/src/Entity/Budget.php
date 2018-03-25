<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetRepository")
 * @SWG\Definition()
 */
class Budget
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"budget_list", "budget_details"})
     *
     * @SWG\Property()
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"budget_list", "budget_details"})
     *
     * @SWG\Property()
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DefaultCategory")
     *
     * @Groups({"budget_details"})
     *
     * @var DefaultCategory
     */
    private $defaultCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Account", mappedBy="budget")
     *
     * @Groups({"budget_details"})
     *
     * @SWG\Property(type="array", @SWG\Items(ref="#/definitions/Account"))
     *
     * @var Collection|Account[]
     */
    private $accounts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetOwnership", mappedBy="budget", fetch="EXTRA_LAZY")
     *
     * @Groups({"budget_details"})
     *
     * @var Collection|BudgetOwnership[]
     */
    private $budgetOwnerships;

    /**
     * @ORM\OneToMany(targetEntity="MoneyCategory", mappedBy="budget")
     *
     * @Groups({"budget_details"})
     *
     * @SWG\Property(type="array", @SWG\Items(ref="#/definitions/BudgetCategory"))
     *
     * @var Collection|MoneyCategory[]
     */
    private $moneyCategories;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->budgetOwnerships = new ArrayCollection();
        $this->moneyCategories = new ArrayCollection();
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
     * @return DefaultCategory
     */
    public function getDefaultCategory(): DefaultCategory
    {
        return $this->defaultCategory;
    }

    /**
     * @param DefaultCategory $defaultCategory
     */
    public function setDefaultCategory(DefaultCategory $defaultCategory): void
    {
        $this->defaultCategory = $defaultCategory;
    }

    /**
     * @return Account[]|Collection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * @param Account[]|Collection $accounts
     */
    public function setAccounts($accounts): void
    {
        $this->accounts = $accounts;
    }

    /**
     * @return BudgetOwnership[]|Collection
     */
    public function getBudgetOwnerships()
    {
        return $this->budgetOwnerships;
    }

    /**
     * @param BudgetOwnership[]|Collection $budgetOwnerships
     */
    public function setBudgetOwnerships($budgetOwnerships): void
    {
        $this->budgetOwnerships = $budgetOwnerships;
    }

    /**
     * @return MoneyCategory[]|Collection
     */
    public function getMoneyCategories()
    {
        return $this->moneyCategories;
    }

    /**
     * @param MoneyCategory[]|Collection $moneyCategories
     */
    public function setMoneyCategories($moneyCategories): void
    {
        $this->moneyCategories = $moneyCategories;
    }

    /**
     * @param Account $account
     */
    public function addAccount(Account $account)
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts->add($account);
            $account->setBudget($this);
        }
    }

    /**
     * @param Account $account
     */
    public function removeAccount(Account $account)
    {
        if ($this->accounts->contains($account)) {
            $this->accounts->removeElement($account);
            $account->setBudget(null);
        }
    }

    /**
     * @param BudgetOwnership $budgetOwnership
     */
    public function addBudgetOwnership(BudgetOwnership $budgetOwnership)
    {
        if (!$this->budgetOwnerships->contains($budgetOwnership)) {
            $this->budgetOwnerships->add($budgetOwnership);
            $budgetOwnership->setBudget($this);
        }
    }

    /**
     * @param BudgetOwnership $budgetOwnership
     */
    public function removeBudgetOwnership(BudgetOwnership $budgetOwnership)
    {
        if ($this->budgetOwnerships->contains($budgetOwnership)) {
            $this->budgetOwnerships->removeElement($budgetOwnership);
            $budgetOwnership->setBudget(null);
        }
    }

    /**
     * @param MoneyCategory $category
     */
    public function addCategory(MoneyCategory $category)
    {
        if (!$this->moneyCategories->contains($category)) {
            $this->moneyCategories->add($category);
            $category->setBudget($this);
        }
    }

    /**
     * @param MoneyCategory $category
     */
    public function removeCategory(MoneyCategory $category)
    {
        if ($this->moneyCategories->contains($category)) {
            $this->moneyCategories->removeElement($category);
            $category->setBudget(null);
        }
    }

}
