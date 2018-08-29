<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 20.06.2018
 * Time: 18:01
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function apiPlatformAdmin() {
        return $this->render('default/apiPlatformAdmin.html.twig');
    }
}