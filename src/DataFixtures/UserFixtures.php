<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 11.07.2018
 * Time: 17:37
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture implements DependentFixtureInterface
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new Entity\User();

        $password = $this->passwordEncoder->encodePassword($user, 'admin');
        $user->setUsername('admin')->setEmail('admin@pokus.cz')->setPassword($password);
        $user->setFirstname('Admin')->setLastname('Adminovič')->setSchool($this->getReference('school'));
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $this->setReference('admin', $user);
        $manager->persist($user);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SchoolFixtures::class,
        );
    }
}
