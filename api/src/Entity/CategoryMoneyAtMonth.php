<?php

namespace App\Entity;

use Cake\Chronos\Chronos;
use Cake\Chronos\Date;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Money;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="CategoryMoneyAtMonthRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(columns={"month", "year", "category_id"})})
 */
class CategoryMoneyAtMonth
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"category_budget_list"})
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", length=2)
     *
     * @var int
     */
    private $month;

    /**
     * @ORM\Column(type="smallint", length=4)
     *
     * @var int
     */
    private $year;

    /**
     * @ORM\Embedded(class="Money\Money")
     *
     * @Groups({"category_budget_list"})
     *
     * @var Money
     */
    private $money;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="categoryBudgetAtMonths")
     *
     * @Groups({"category_budget_list"})
     *
     * @var Category
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetTransaction", mappedBy="target")
     *
     * @var Collection|BudgetTransaction[]
     */
    private $inflows;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetTransaction", mappedBy="source")
     *
     * @var Collection|BudgetTransaction[]
     */
    private $outflows;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @param int $month
     */
    public function setMonth(int $month): void
    {
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
}
