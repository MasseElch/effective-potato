<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Budget", inversedBy="categories")
     *
     * @var Budget
     */
    private $budget;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategoryBudgetAtMonth", mappedBy="category")
     *
     * @var Collection|CategoryBudgetAtMonth[]
     */
    private $categoryBudgetAtMonths;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="category")
     *
     * @var Collection|Transaction[]
     */
    private $transactions;
}
