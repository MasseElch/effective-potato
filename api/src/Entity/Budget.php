<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetRepository")
 */
class Budget
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
     * @ORM\Column(type="currency")
     *
     * @var Currency
     */
    private $currency;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Account", mappedBy="budget")
     *
     * @var Collection|Account[]
     */
    private $accounts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetOwnership", mappedBy="budget")
     *
     * @var Collection|BudgetOwnership[]
     */
    private $budgetOwnerships;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="budget")
     *
     * @var Collection|Category[]
     */
    private $categories;
}
