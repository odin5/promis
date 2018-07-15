<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 10.07.2018
 * Time: 18:01
 */

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{

    /* Route for this action is defined in /config/routes.yaml (name "login", path "/login") */
    public function login(Request $request, AuthenticationUtils $authenticationUtils) {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig',
            array(
                'last_username' => $lastUsername, // last username entered by the user
                'error'         => $error
            ));

    }

    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile()
    {

        return $this->render('user/profile.html.twig');
    }

    public function manageUsers(EntityManagerInterface $em) {
        $em->getFilters()->disable('softdeleteable');
    }
}