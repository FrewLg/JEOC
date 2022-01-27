<?php

namespace App\Security\Voter;
use App\Entity\Group;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class GroupVoter extends Voter
{
    private $decisionManager;
    // these strings are just invented: you can use anything
    const VIEW_GROUP = 'VIEW_GROUP';
    const EDIT_GROUP = 'EDIT_GROUP';
    const DELETE_GROUP = 'DELETE_GROUP';

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW_GROUP, self::EDIT_GROUP, self::DELETE_GROUP))) {
            return false;
        }

        // only vote on MISQuery objects inside this voter
        if (!$subject instanceof Group) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if ($user &&   $user->getIsSuperAdmin())
        return true;

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
            return true;
        }
        // you know $subject is a Post object, thanks to supports
        /** @var Group $group */
        $group = $subject;

        switch ($attribute) {
            case self::VIEW_GROUP:
                $permission = "VIEW_GROUP";
                return $this->checkAuthorization($group, $user, $permission);

            case self::EDIT_GROUP:
                $permission = "EDIT_GROUP";
                return $this->checkAuthorization($group, $user, $permission);

            case self::DELETE_GROUP:
                $permission = "DELETE_GROUP";
                return $this->checkAuthorization($group, $user, $permission);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function checkAuthorization(Group $selectedGroup, User $user, $permission)
    {
        $group = $user->getUserGroup();
        if(empty($group)){
            return false;
        }
        $permissions = $group->getPermissions();
        foreach ($permissions as $groupPermission){
            if($groupPermission->getName() === $permission){
                return true;
            }
        }
        return false;
    }
}
