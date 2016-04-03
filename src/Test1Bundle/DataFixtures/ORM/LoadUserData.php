<?php
/**
 * Created by PhpStorm.
 * User: Eligijus Stugys
 * Date: 2016.04.03
 * Time: 12:14
 */

namespace Test1Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Test1Bundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Prepare "admin" user data:
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setIsActive(true);
        $userAdmin->setEmail("admin@Test1Bundle.lt");

        // Prepare password:
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($userAdmin, 'admin');
        $userAdmin->setPassword($encoded);

        // Save to DB:
        $manager->persist($userAdmin);
        $manager->flush();
    }
}