<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setName('Marion');
        $contributor->setLastname('Judfruit');
        $contributor->setBirthday(new \DateTime('12/29/1991'));
        $contributor->setEmail('marion@connectevent.com');
        $contributor->setCountry('Bordeaux');
        $contributor->setCar(true);
        $contributor->setHandicap(false);
        $contributor->setPresentation('Bonjour à tous ! ');
        $contributor->setActivities('Sportive');
        $contributor->setPassword('Marionade');


        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'Marionade'
        );

        $contributor->setPassword($hashedPassword);
        $manager->persist($contributor);

        // Sauvegarde des utilisateurs :
        $manager->flush();
    }
}