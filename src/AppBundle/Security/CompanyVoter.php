<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Test1Bundle\Entity\User;

class CompanyVoter extends Voter
{
    private const VIEW = 'ROLE_CAN_VIEW_COMPANIES';

    private const MANAGE = 'ROLE_CAN_MANAGE_COMPANIES';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        // If the attribute isn't one we support, return false:
        if (!in_array($attribute, array(self::VIEW, self::MANAGE))) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute
     * @param mixed          $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $user->getUsername() === 'admin';
            case self::MANAGE:
                return $user->getUsername() === 'admin';
        }

        throw new \LogicException('This code should not be reached!');
    }
}