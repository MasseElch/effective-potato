<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountOwnershipRepository")
 */
class AccountOwnership
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Account", inversedBy="accountOwnerships")
     *
     * @var Account
     */
    private $account;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="accountOwnerships")
     *
     * @var User
     */
    private $user;
}
