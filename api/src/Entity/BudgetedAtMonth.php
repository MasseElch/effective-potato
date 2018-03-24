<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Money;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetedAtMonthRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(columns={"month", "year", "category_id"})})
 * @SWG\Definition()
 */
class BudgetedAtMonth
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"budget_at_month_list"})
     *
     * @SWG\Property()
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
     * @Groups({"budget_at_month_list"})
     *
     * @SWG\Property(property="money", ref="#/definitions/Money")
     *
     * @var Money
     */
    private $money;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="budgetedAtMonth")
     *
     * @var Category
     */
    private $category;

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
    public function getMonth(): ?int
    {
        return $this->month;
    }

    /**
     * @param int $month
     */
    public function setMonth(?int $month): void
    {
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return Money
     */
    public function getMoney(): ?Money
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
