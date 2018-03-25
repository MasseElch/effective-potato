<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DefaultCategoryRepository")
 */
class DefaultCategory extends Category
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Budget", inversedBy="defaultCategory")
     *
     * @var Budget
     */
    protected $budget;
}
