<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 20.06.2018
 * Time: 18:01
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    public function index() {
        return $this->render('default/index.html.twig');
    }

    public function login() {
        return $this->render('default/login.html.twig');
    }
}