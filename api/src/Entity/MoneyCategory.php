<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoneyCategoryRepository")
 * @SWG\Definition()
 */
class MoneyCategory extends Category
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Budget", inversedBy="moneyCategories")
     *
     * @var Budget
     */
    protected $budget;
}
