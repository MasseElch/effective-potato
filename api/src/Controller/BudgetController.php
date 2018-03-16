<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BudgetController
 * @package App\Controller
 *
 * @Route("/budgets")
 */
class BudgetController extends Controller
{
    /**
     * @Rest\Get("/{id}/{year}/{month}")
     */
    public function budget()
    {
        return $this->render('budget/index.html.twig', [
            'controller_name' => 'BudgetController',
        ]);
    }
}
