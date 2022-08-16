<?php

namespace App\module\user\dataFixtures;

use App\module\user\entity\User;
use Cassandra\Date;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $user = new User();
        $user->setEmail("admen@gmail.com");
        $user->setPassword($this->hasher->hashPassword($user, "12345678"));
        $user->setCreatedAt();
        $user->setCreatedAt();

        $manager->persist($user);
        $manager->flush();
    }
}