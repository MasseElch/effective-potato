<?php

namespace App\Security\Voter;

use App\Entity\Budget;
use App\Repository\BudgetOwnershipRepository;
use App\Repository\BudgetRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BudgetVoter extends Voter
{
    const VIEW = 'VIEW';

    /**
     * @var BudgetRepository
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
        return in_array($attribute, [self::VIEW])
            && $subject instanceof Budget;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Budget $budget */
        $budget = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
                // Can only view if there does exist an ownership of the given budget
                return $this->budgetOwnershipRepository->count(['user' => $user, 'budget' => $budget]);
                break;
        }

        return false;
    }
}
