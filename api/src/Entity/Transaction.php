<?php

namespace App\Entity;

use Cake\Chronos\Chronos;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
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
    private $amount;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var Chronos
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Account", inversedBy="transactions")
     *
     * @var Account
     */
    private $account;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="transactions")
     *
     * @var Category
     */
    private $category;
}
