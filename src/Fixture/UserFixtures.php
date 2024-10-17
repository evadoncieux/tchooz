<?php

namespace App\Fixture;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher, private readonly SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername('admin')
            ->setPassword($this->passwordHasher->hashPassword($admin, 'gdf74ds5sd7sd56'))
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@admin.com')
            ->setSlug((strtolower($this->slugger->slug('admin'))))
            ->setVerified(true);
        $manager->persist($admin);

        $userEva = new User();
        $userEva->setUsername('eva')
            ->setPassword($this->passwordHasher->hashPassword($userEva, 'lyoncestmamaison'))
            ->setRoles(['ROLE_USER'])
            ->setEmail('eva@lyon.fr')
            ->setLocation('Lyon, FR')
            ->setSlug((strtolower($this->slugger->slug('eva'))))
            ->setVerified(true);
        $manager->persist($userEva);

        $userFlo = new User();
        $userFlo->setUsername('pucci')
            ->setPassword($this->passwordHasher->hashPassword($userFlo, 'imarat'))
            ->setRoles(['ROLE_USER'])
            ->setEmail('flora@iloveny.com')
            ->setLocation('NY, NY, USA')
            ->setSlug((strtolower($this->slugger->slug('flo'))))
            ->setVerified(true);
        $manager->persist($userFlo);

        $userLise = new User();
        $userLise->setUsername('lise')
            ->setPassword($this->passwordHasher->hashPassword($userLise, 'londonandtea'))
            ->setRoles(['ROLE_USER'])
            ->setEmail('paddington@london.uk')
            ->setLocation('London, UK')
            ->setSlug((strtolower($this->slugger->slug('lise'))))
            ->setVerified(false);
        $manager->persist($userLise);

        $this->addReference('user_admin', $admin);
        $this->addReference('user_eva', $userEva);
        $this->addReference('user_pucci', $userFlo);
        $this->addReference('user_paddington', $userLise);

        $manager->flush();
    }
}
