<?php

namespace App\Security\Voter;

use App\Entity\Category;
use App\Entity\MoneyCategory;
use App\Repository\BudgetOwnershipRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CategoryVoter extends Voter
{
    const EDIT = 'EDIT';

    /**
     * @var BudgetOwnershipRepository
     */
    private $budgetOwnershipRepository;

    public function __construct(BudgetOwnershipRepository $budgetOwnershipRepository)
    {
        $this->budgetOwnershipRepository = $budgetOwnershipRepository;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT])
            && $subject instanceof MoneyCategory;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Category $category */
        $category = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // Can only edit if the category's budget is owned by the current user
                return $this->budgetOwnershipRepository->count(['user' => $user, 'budget' => $category->getBudget()]);
        }

        return false;
    }
}
