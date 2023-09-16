<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Helpers\SlugFromEmail;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private SlugFromEmail $slugFromEmail
    )
    {
        
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = (new User())
        ->setEmail('azizk@gmail.com')
        ->setNom('KAMAGATE Amadou Aziz')
        ->setSlug(($this->slugFromEmail)(
            email: 'azizk@gmail.com'
        ));
        $password = $this->hasher->hashPassword($user, 'aziz');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}
