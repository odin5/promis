<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 11.07.2018
 * Time: 17:37
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {
        $user = new Entity\User();

        $password = $this->passwordEncoder->encodePassword($user, 'admin');
        $user->setUsername('admin')->setEmail('admin@pokus.cz')->setPassword($password);
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $this->setReference('user1', $user);
        $manager->persist($user);

        $manager->flush();
    }

//    public function getDependencies()
//    {
//        return array(
//            UserFixtures::class,
//        );
//    }
}

?>