<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername('admin')
            ->setPassword($this->passwordHasher->hashPassword($admin, 'admin'))
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@admin.com')
            ->setVerified(true);
        $manager->persist($admin);

        $userGuignol = new User();
        $userGuignol->setUsername('guignol')
            ->setPassword($this->passwordHasher->hashPassword($userGuignol, 'lyoncestmamaison'))
            ->setRoles(['ROLE_USER'])
            ->setEmail('guignol@lyon.fr')
            ->setLocation('Lyon, FR')
            ->setVerified(true);
        $manager->persist($userGuignol);

        $userPucci = new User();
        $userPucci->setUsername('pucci')
            ->setPassword($this->passwordHasher->hashPassword($userPucci, 'imarat'))
            ->setRoles(['ROLE_USER'])
            ->setEmail('pucci@iloveny.com')
            ->setLocation('NY, NY, USA')
            ->setVerified(true);
        $manager->persist($userPucci);

        $userPaddington = new User();
        $userPaddington->setUsername('paddington')
            ->setPassword($this->passwordHasher->hashPassword($userPaddington, 'londonandtea'))
            ->setRoles(['ROLE_USER'])
            ->setEmail('paddington@london.uk')
            ->setLocation('London, UK')
            ->setVerified(false);
        $manager->persist($userPaddington);

        $this->addReference('user_admin', $admin);
        $this->addReference('user_guignol', $userGuignol);
        $this->addReference('user_pucci', $userPucci);
        $this->addReference('user_paddington', $userPaddington);

        $manager->flush();
    }
}
