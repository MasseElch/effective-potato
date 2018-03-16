<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, JWTUserInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"user_token", "user_list"})
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     *
     * @Groups({"user_token", "user_list"})
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="is_enabled", type="boolean")
     *
     * @Groups({"user_token"})
     *
     * @var boolean
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AccountOwnership", mappedBy="user")
     *
     * @var Collection|AccountOwnership[]
     */
    private $accountOwnerships;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetOwnership", mappedBy="user")
     *
     * @var Collection|BudgetOwnership[]
     */
    private $budgetOwnerships;

    public function __construct()
    {
        $this->enabled = true;
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public static function createFromPayload($username, array $payload)
    {
        $self = new self();
        $self->setId($payload['user']['id']);
        $self->setEmail($payload['username']);

        return $self;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword= $plainPassword;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
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
     * @return BudgetOwnership[]|Collection
     */
    public function getBudgetOwnerships()
    {
        return $this->budgetOwnerships;
    }

    /**
     * @param BudgetOwnership[]|Collection $budgetOwnerships
     */
    public function setBudgetOwnerships($budgetOwnerships): void
    {
        $this->budgetOwnerships = $budgetOwnerships;
    }

    /**
     * @param AccountOwnership $accountOwnership
     */
    public function addAccountOwnership(AccountOwnership $accountOwnership)
    {
        if (!$this->accountOwnerships->contains($accountOwnership)) {
            $this->accountOwnerships->add($accountOwnership);
            $accountOwnership->setUser($this);
        }
    }

    /**
     * @param AccountOwnership $accountOwnership
     */
    public function removeAccountOwnership(AccountOwnership $accountOwnership)
    {
        if ($this->accountOwnerships->contains($accountOwnership)) {
            $this->accountOwnerships->removeElement($accountOwnership);
            $accountOwnership->setUser(null);
        }
    }

    /**
     * @param BudgetOwnership $budgetOwnership
     */
    public function addBudgetOwnership(BudgetOwnership $budgetOwnership)
    {
        if (!$this->budgetOwnerships->contains($budgetOwnership)) {
            $this->budgetOwnerships->add($budgetOwnership);
            $budgetOwnership->setUser($this);
        }
    }

    /**
     * @param BudgetOwnership $budgetOwnership
     */
    public function removeBudgetOwnership(BudgetOwnership $budgetOwnership)
    {
        if ($this->budgetOwnerships->contains($budgetOwnership)) {
            $this->budgetOwnerships->removeElement($budgetOwnership);
            $budgetOwnership->setUser(null);
        }
    }

}