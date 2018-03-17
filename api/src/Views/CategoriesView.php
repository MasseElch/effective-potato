<?php

namespace App\Views;
use App\Entity\BudgetedAtMonth;
use App\Entity\Category;
use Doctrine\Common\Collections\Collection;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class BudgetView
 * @package App\Views
 *
 * @SWG\Definition()
 */
class CategoriesView
{
    /**
     * @SWG\Property()
     *
     * @Groups({"category_list"})
     *
     * @var Category
     */
    public $defaultCategory;

    /**
     * @SWG\Property()
     *
     * @Groups({"budget_at_month_list"})
     *
     * @var BudgetedAtMonth
     */
    public $defaultCategoryBudgetedAtMonth;

    /**
     * @SWG\Property()
     *
     * @Groups({"category_list"})
     *
     * @var Category[]
     */
    public $categories;

    /**
     * @SWG\Property()
     *
     * @Groups({"budget_at_month_list"})
     *
     * @var BudgetedAtMonth[]
     */
    public $categoryBudgetedAtMonths;

    public function __construct(Category $defaultCategory, BudgetedAtMonth $defaultCategoryBudgetedAtMonth, $categories, $categoryBudgetedAtMonths)
    {
        $this->defaultCategory = $defaultCategory;
        $this->defaultCategoryBudgetedAtMonth = $defaultCategoryBudgetedAtMonth;
        $this->categories = $categories;

        // Index the given categoryBudgetsAtMonths by the attached category id
        $this->categoryBudgetedAtMonths = [];
        foreach ($categoryBudgetedAtMonths as $budgetedAtMonth) {
            /** @var BudgetedAtMonth $budgetedAtMonth */
            $this->categoryBudgetedAtMonths[$budgetedAtMonth->getCategory()->getId()] = $budgetedAtMonth;
        }
    }
}