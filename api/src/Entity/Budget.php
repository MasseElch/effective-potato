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
     * @var defaultCategory
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
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="budget")
     *
     * @Groups({"budget_details"})
     *
     * @var Collection|Category[]
     */
    private $categories;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->budgetOwnerships = new ArrayCollection();
        $this->categories = new ArrayCollection();
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
     * @return defaultCategory
     */
    public function getDefaultCategory(): defaultCategory
    {
        return $this->defaultCategory;
    }

    /**
     * @param defaultCategory $defaultCategory
     */
    public function setDefaultCategory(defaultCategory $defaultCategory): void
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
     * @return Category[]|Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category[]|Collection $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
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
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setBudget($this);
        }
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->setBudget(null);
        }
    }

}
