<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetOwnershipRepository")
 */
class BudgetOwnership
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"budget_ownership_list"})
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Budget", inversedBy="budgetOwnerships")
     *
     * @var Budget
     */
    private $budget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="budgetOwnerships")
     *
     * @Groups({"budget_ownership_list"})
     *
     * @var User
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
