<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 16.08.2018 15:28
 */
namespace App\Security;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
{
    const PLAY = 'play';
    const EDIT = 'edit';
    const supportedAttributes = [self::PLAY, self::EDIT];

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, self::supportedAttributes)) return false; // if the attribute isn't one we support, return false = abstain
        if (!$subject instanceof Project) return false; // only vote on Project objects inside this voter
        return true;
    }

    protected function voteOnAttribute($attribute, $project, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) { // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::PLAY:
                return $this->canPlay($project, $user);
            case self::EDIT:
                return $this->canEdit($project, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canPlay(Project $project, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($project, $user)) {
            return true;
        }

        return $user->getAllowedProjects()->contains($project);
    }

    private function canEdit(Project $project, User $user)
    {

        return $user->getAllowedProjectEdits()->contains($project);
    }
}