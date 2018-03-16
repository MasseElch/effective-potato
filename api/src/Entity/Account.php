<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Money;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"account_list"})
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"account_list"})
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Embedded(class="Money\Money")
     *
     * @Groups({"account_list"})
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

    public function __construct()
    {
        $this->accountOwnerships = new ArrayCollection();
        $this->transactions = new ArrayCollection();
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
     * @return Money
     */
    public function getBalance(): Money
    {
        return $this->balance;
    }

    /**
     * @param Money $balance
     */
    public function setBalance(Money $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return Budget
     */
    public function getBudget(): Budget
    {
        return $this->budget;
    }

    /**
     * @param Budget $budget
     */
    public function setBudget(Budget $budget): void
    {
        $this->budget = $budget;
    }

    /**
     * @return AccountOwnership[]|Collection
     */
    public function getAccountOwnerships()
    {
        return $this->accountOwnerships;
    }

    /**
     * @param AccountOwnership[]|Collection $accountOwnerships
     */
    public function setAccountOwnerships($accountOwnerships): void
    {
        $this->accountOwnerships = $accountOwnerships;
    }

    /**
     * @return Transaction[]|Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param Transaction[]|Collection $transactions
     */
    public function setTransactions($transactions): void
    {
        $this->transactions = $transactions;
    }

    /**
     * @param AccountOwnership $accountOwnership
     */
    public function addAccountOwnership(AccountOwnership $accountOwnership)
    {
        if (!$this->accountOwnerships->contains($accountOwnership)) {
            $this->accountOwnerships->add($accountOwnership);
            $accountOwnership->setAccount($this);
        }
    }

    /**
     * @param AccountOwnership $accountOwnership
     */
    public function removeAccountOwnership(AccountOwnership $accountOwnership)
    {
        if ($this->accountOwnerships->contains($accountOwnership)) {
            $this->accountOwnerships->removeElement($accountOwnership);
            $accountOwnership->setAccount(null);
        }
    }

    /**
     * @param Transaction $transaction
     */
    public function addTransaction(Transaction $transaction)
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setAccount($this);
        }
    }

    /**
     * @param Transaction $transaction
     */
    public function removeTransaction(Transaction $transaction)
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            $transaction->setAccount(null);
        }
    }

}
