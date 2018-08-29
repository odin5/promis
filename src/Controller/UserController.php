<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 10.07.2018
 * Time: 18:01
 */

namespace App\Controller;

use App\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    /* Route for this action is defined in /config/routes.yaml (name "login", path "/login") */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $em = $this->getDoctrine()->getManager();
//        $school = new School();
//        $school->translate('cs')->setName('Pokus2cs');
//        $school->translate('en')->setName('Pokus2en');
//        $school->mergeNewTranslations();
//        $em->persist($school);
//        $em->flush();
        $s = $em->getRepository(Entity\School::class)->find(1);
        $s = $em->getRepository(Entity\SchoolTranslation::class)->findOneBy(['locale' => 'cs']);
        $icon = new Entity\Icon();
        $form = $this->createFormBuilder($icon)
            ->add('fileUpload', \Symfony\Component\Form\Extension\Core\Type\FileType::class)
            ->add('save', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class)
            ->getForm();
        ;
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($icon);

                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                // Here, "getMyFile" returns the "UploadedFile" instance that the form bound in your $myFile property
                $uploadableManager->markEntityToUpload($icon, $icon->getFileUpload());

                $em->flush();
                echo 'jupi';

                return null;
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig',
            array(
                'last_username' => $lastUsername, // last username entered by the user
                'error'         => $error,
                'form' => $form->createView()
            ));

    }

    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(UserInterface $user)
    {
        if(!($user instanceof Entity\User)) throw new \InvalidArgumentException('Instance uživatele má špatný typ');

        return $this->render('user/profile.html.twig', [
            'projects' => $user->getAllowedProjects()
        ]);
    }

    /**
     * @Route("/change-password")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passwordChange(Request $request, UserInterface $user, UserPasswordEncoderInterface $passwordEncoder)
    {
        if(!($user instanceof Entity\User)) throw new \InvalidArgumentException('Instance uživatele má špatný typ');
        $form = $this->createForm(\App\Form\User\ChangePasswordType::class, []);

        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $formData = $form->getData();

                $newPasswordHash = $passwordEncoder->encodePassword($user, $formData['newPassword']);
                $user->setPassword($newPasswordHash);

                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Vaše heslo bylo úspěšně změněno');
                return $this->redirect( $this->generateURL('app_user_profile') );
            }
        }
        return $this->render('User\changePassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }



    public function manageUsers(EntityManagerInterface $em) {
        $em->getFilters()->disable('softdeleteable');
    }
}