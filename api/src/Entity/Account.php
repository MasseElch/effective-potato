<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Embedded(class="Money\Money")
     *
     * @var Money
     */
    private $balance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Budget", inversedBy="accounts")
     *
     * @var Budget
     */
    private $budget;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AccountOwnership", mappedBy="account")
     *
     * @var Collection|AccountOwnership[]
     */
    private $accountOwnerships;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="account")
     *
     * @var Collection|Transaction[]
     */
    private $transactions;
}
