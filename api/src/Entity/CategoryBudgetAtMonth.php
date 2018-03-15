<?php

namespace App\Entity;

use Cake\Chronos\Chronos;
use Cake\Chronos\Date;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryBudgetAtMonthRepository")
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
     * @ORM\Column(type="date_immutable")
     *
     * @var Date
     */
    private $date;

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
     * @return Date
     */
    public function getDate(): Date
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     */
    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = Chronos::instance($date);
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
