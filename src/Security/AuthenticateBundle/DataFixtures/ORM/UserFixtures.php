<?php

namespace Security\AuthenticateBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Security\AuthenticateBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class UserFixtures extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('davidmaignan@gmail.com');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_ADMIN', 'ROLE_REVIEWER', 'ROLE_REVIEWER_PHP', 'ROLE_REVIEWER_JAVASCRIPT','ROLE_EXAM_OWNER'));
        //$userAdmin->setSalt(md5(time()));

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);
        $userAdmin->setPassword($encoder->encodePassword('adminpass', $userAdmin->getSalt()));

        $manager->persist($userAdmin);
        
        $this->addReference('user-1', $userAdmin);
        
        $userAdmin = new User();
        $userAdmin->setUsername('user');
        $userAdmin->setEmail('user@test.com');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_USER', 'ROLE_OWNER', 'ROLE_EXAM_OWNER'));
        //$userAdmin->setSalt(md5(time()));

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);
        $userAdmin->setPassword($encoder->encodePassword('userpass', $userAdmin->getSalt()));

        $manager->persist($userAdmin);
        
        $this->addReference('user-2', $userAdmin);
        
        $userAdmin = new User();
        $userAdmin->setUsername('david');
        $userAdmin->setEmail('david@test.com');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_USER', 'ROLE_EXAM_CANDIDATE'));
        //$userAdmin->setSalt(md5(time()));

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);
        $userAdmin->setPassword($encoder->encodePassword('camper', $userAdmin->getSalt()));

        $manager->persist($userAdmin);
        
        $this->addReference('user-3', $userAdmin);
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
    
}
