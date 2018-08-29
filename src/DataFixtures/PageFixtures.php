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


class PageFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $page = new Entity\Page();
        $page->setAppPages(['lecture']);
        $page->translate('cs')->setPath('lecture')->setTitle('Skripta')->setContent('<h2>Obsah skript</h2>');
        $page->mergeNewTranslations();
        $manager->persist($page);

        $manager->flush();
    }

//    public function getDependencies()
//    {
//        return array(
//            SchoolFixtures::class,
//        );
//    }
}
