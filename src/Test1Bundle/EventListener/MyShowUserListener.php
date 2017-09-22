<?php
namespace Test1Bundle\EventListener;

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Test1Bundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MyShowUserListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param TokenStorageInterface $token_storage
     */
    public function __construct(TokenStorageInterface $token_storage)
    {
        $this->tokenStorage = $token_storage;
    }

    /**
     * @param ShowUserEvent $event
     */
    public function onShowUser(ShowUserEvent $event)
    {

        $user = $this->getUser();
        $event->setUser($user);
    }

    /**
     * Return logged in user object.
     *
     * @return User
     */
    protected function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}
