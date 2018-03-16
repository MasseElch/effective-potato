<?php

namespace App\Entity;

use Cake\Chronos\Chronos;
use Cake\Chronos\Date;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryBudgetAtMonthRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(columns={"month", "year", "category_id"})})
 */
class CategoryBudgetAtMonth
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="categoryBudgetAtMonths")
     *
     * @var Category
     */
    private $category;

    /**
     * @ORM\Embedded(class="Money\Money")
     *
     * @var Money
     */
    private $budget;

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

    /**
     * @return Money
     */
    public function getBudget(): Money
    {
        return $this->budget;
    }

    /**
     * @param Money $budget
     */
    public function setBudget(Money $budget): void
    {
        $this->budget = $budget;
    }
}
