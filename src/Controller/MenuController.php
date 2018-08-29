<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 23.08.2018 18:26
 */

namespace App\Controller;


use App\Service\LeftMenuManager;

class MenuController extends AbstractController
{
    public function leftMenuContent(LeftMenuManager $manager)
    {
        return $this->render('Menu/menuContentRecursive.html.twig', ['items' => $manager->getMenu()]);
    }
}