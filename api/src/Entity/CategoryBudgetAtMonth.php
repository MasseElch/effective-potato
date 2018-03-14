<?php

namespace App\Entity;

use Cake\Chronos\Date;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryBudgetAtMonthRepository")
 */
class CategoryBudgetAtMonth
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
}
