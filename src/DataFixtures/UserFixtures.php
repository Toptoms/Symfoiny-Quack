<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
        {
           $this->passwordEncoder = $passwordEncoder;
        }
    public function load(ObjectManager $manager)
    {
        
            $user = new User();
            $user->setUsername('coincoin');
            $user->setPassword("123");
            $user->setEmail("gerard@quack.com");
            $user->setFirstname("gerard");
            $user->setLastname("depardieu");
            $user->setRoles(array('ROLE_USER'));
          
            $user->setPassword($this->passwordEncoder->encodePassword(
                            $user,
                            'the_new_password'
                    ));
                    $manager->persist($user);
            // add more products
    
   
        $manager->flush();
    }
}