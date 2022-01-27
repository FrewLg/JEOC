<?php

 
namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class GeneralVoter extends Voter {

    private $decisionManager;

    // these strings are just invented: you can use anything
    const LIST_GROUP = 'LIST_GROUP';
    const CREATE_GROUP = 'CREATE_GROUP';
    const LIST_PERMISSION = 'LIST_PERMISSION';
    const CREATE_PERMISSION = 'CREATE_PERMISSION';
    const LIST_USER = 'LIST_USER';
    const CREATE_USER = 'CREATE_USER';
    const LIST_ASSET_TYPE='LIST_ASSET_TYPE';

    public function __construct(AccessDecisionManagerInterface $decisionManager) {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject) {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(
                    self::LIST_GROUP,
                    self::CREATE_GROUP,
                    self::LIST_PERMISSION,
                    self::CREATE_PERMISSION,
                    self::LIST_USER,
                    self::CREATE_USER,
                    self::LIST_ASSET_TYPE,
                    

                ))) {
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
//        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
        if ($this->checkAuthorization($user, 'ROLE_SUPER_ADMIN')) {
            return true;
        }

        switch ($attribute) {
            case self::CREATE_USER:
                $permission = "CREATE_USER";
                return $this->checkAuthorization($user, $permission);
            case self::LIST_USER:
                $permission = "LIST_USER";
                return $this->checkAuthorization($user, $permission);
            case self::CREATE_PERMISSION:
                $permission = "CREATE_PERMISSION";
                return $this->checkAuthorization($user, $permission);
            case self::LIST_PERMISSION:
                $permission = "LIST_PERMISSION";
                return $this->checkAuthorization($user, $permission);
            case self::LIST_ASSET_TYPE:
                $permission = "LIST_ASSET_TYPE";
                return $this->checkAuthorization($user, $permission);
            case self::CREATE_GROUP:
                $permission = "CREATE_GROUP";
                return $this->checkAuthorization($user, $permission);
            case self::LIST_GROUP:
                $permission = "LIST_GROUP";
                return $this->checkAuthorization($user, $permission);
        }
        throw new \LogicException('This code should not be reached!');
    }

    private function checkAuthorization(User $user, $permission) {
        $roles = $user->getRoles();
        foreach ($roles as $role) {
            if ($role === $permission) {
                return true;
            }
        }
        $groups = $user->getGroups();
        foreach ($groups as $group) {
            $permissions = $group->getPermissions();
            foreach ($permissions as $groupPermission) {
                if ($groupPermission->getName() === $permission) {
                    return true;
                }
            }
        }
        return false;
    }

}
