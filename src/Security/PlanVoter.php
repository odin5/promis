<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 16.08.2018 15:28
 */
namespace App\Security;

use App\Entity\Plan;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PlanVoter extends Voter
{
    const PLAY = 'play';
    const VIEW = 'view';
    const supportedAttributes = [self::PLAY, self::VIEW];

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, self::supportedAttributes)) return false; // if the attribute isn't one we support, return false = abstain
        if (!$subject instanceof Plan) return false; // only vote on Project objects inside this voter
        return true;
    }

    protected function voteOnAttribute($attribute, $plan, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) { // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::PLAY:
                return $this->canPlay($plan, $user);
            case self::VIEW:
                return $this->canView($plan, $token);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canPlay(Plan $plan, User $user)
    {
        return $plan->getPlayersProject()->getPlayer() === $user;
    }

    private function canView(Plan $plan, TokenInterface $token)
    {
        return $this->decisionManager->decide($token, ['ROLE_SUPER_ADMIN']);
    }
}