<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 24.08.2018 10:37
 */

namespace App\Security;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SuperAdminAllowAllVoter extends Voter
{
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        return !empty($subject);
        // everything, cause its the super admin (but must be something, cause otherwise it tests attributes of the token/user itself)
    }

    protected function voteOnAttribute($attribute, $project, TokenInterface $token)
    {
        if (!$token->getUser() instanceof User) { // the user must be logged in; if not, deny access
            return false;
        }

        return $this->decisionManager->decide($token, ['ROLE_SUPER_ADMIN']);
    }
}