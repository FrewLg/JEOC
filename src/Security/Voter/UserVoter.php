<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter {

    private $decisionManager;
    private $security;

    // these strings are just invented: you can use anything
    const USER_CARD_USER = 'USER_CARD_USER';
    const VIEW_USER = 'VIEW_USER';
    const EDIT_USER = 'EDIT_USER';
    const DELETE_USER = 'DELETE_USER';

    public function __construct(AccessDecisionManagerInterface $decisionManager, Security $security) {
        $this->decisionManager = $decisionManager;
        $this->security= $security;
    }

    protected function supports($attribute, $subject) {
      
        // return true;
        if ($this->security->getUser() &&   $this->security->getUser()->getIsSuperAdmin())
            return true;

      
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW_USER, self::USER_CARD_USER, self::EDIT_USER, self::DELETE_USER))) {
            return false;
        }

        // only vote on MISQuery objects inside this voter
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();

        if ($user &&   $user->getIsSuperAdmin())
        return true;


        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
//        if ($this->checkAuthorization($user, 'ROLE_SUPER_ADMIN')) {
            return true;
        }

        // you know $subject is a Post object, thanks to supports
        /** @var User $selectedUser */
        $selectedUser = $subject;

        switch ($attribute) {
            case self::VIEW_USER:
                $permission = "VIEW_USER";
                return $this->checkAuthorization($selectedUser, $user, $permission);
            case self::USER_CARD_USER:
                $permission = "USER_CARD_USER";
                return $this->checkAuthorization($selectedUser, $user, $permission);

            case self::EDIT_USER:
                $permission = "EDIT_USER";
                return $this->checkAuthorization($selectedUser, $user, $permission);

            case self::DELETE_USER:
                $permission = "DELETE_USER";
                return $this->checkAuthorization($selectedUser, $user, $permission);

        }

        throw new \LogicException('This code should not be reached!');
    }


    private function checkAuthorization(User $selectedUser, User $user, $permission) {
        $roles = $user->getRoles();
        foreach ($roles as $role) {
            if ($role === $permission) {
                return true;
            }
        }
        $groups = $user->getGroups();
        foreach ($groups as $group){
            $permissions = $group->getPermissions();
            foreach ($permissions as $groupPermission){
                if($groupPermission->getName() === $permission){
                    return true;
                }
            }
        }
        return false;
    }

}
