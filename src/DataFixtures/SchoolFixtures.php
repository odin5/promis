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


class SchoolFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $school = new Entity\School();
        $school->translate('cs')->setName('MUNI');
        $school->mergeNewTranslations();
        $this->setReference('school', $school);
        $manager->persist($school);

        $manager->flush();
    }

//    public function getDependencies()
//    {
//        return array(
//            SchoolFixtures::class,
//        );
//    }
}
