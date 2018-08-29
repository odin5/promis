<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 16.08.2018 17:33
 */

namespace App\Controller;

use App\Entity;
use App\Security\ProjectVoter;
use App\Service\LeftMenuManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class ProjectController
 * @Route({
 *     "cs": "/projekt",
 *     "en": "/project"
 * })
 */
class ProjectController extends AbstractController
{

    /**
     * @Route({
     *     "cs": "/{project}/vybrat-plan",
     *     "en": "/{project}/choose-plan"
     * }, requirements={"project": "\d+"})
     */
    public function selectPlan(LeftMenuManager $menu, Entity\Project $project, UserInterface $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted(ProjectVoter::PLAY, $project);
        $menu->markActive('selectPlan');

        $newPlanNum = 1 + $this->em->getRepository(Entity\Plan::class)->countPlansOfUser($user);
        $defaultName = $this->trans('Plán') .' '. $newPlanNum;

        $pp = $this->em->getRepository(Entity\PlayersProject::class)
            ->findOneBy([ 'project' => $project ]);
        if(empty($pp)) {
            $pp = new Entity\PlayersProject($project, $user);
            $this->em->persist($pp);

            $plan = new Entity\Plan();
            if(method_exists($plan, 'translate')) {
                $plan->translate(\App\Config::getDefaultLocale())->setName($defaultName);
                $plan->mergeNewTranslations();
            }
            else $plan->setName($defaultName);
            $plan->setPlayersProject($pp);
            $this->em->persist($plan);

            $pp->setLastPlan($plan);
            $this->em->flush();

            $newPlanNum = 1 + $this->em->getRepository(Entity\Plan::class)->countPlansOfUser($user);
            $defaultName = $this->trans('Plán') .' '. $newPlanNum;
        }
        $request->getSession()->set('plan', $pp->getLastPlan());

        $fb = $this->createFormBuilder(['plan' => $pp->getLastPlan(), 'name' => $defaultName])
            ->add('plan', EntityType::class, [
                'label' => 'Aktuální plán',
                'class' => Entity\Plan::class,
                'choices' => $this->em->getRepository(Entity\Plan::class)->findBy([
                    'playersProject' => $pp, 'isInGame' => false, 'isHidden' => false
                ]),
            ])
            ->add('name', TextType::class, [
                'label' => 'Jméno plánu',
                'constraints' => [ new Length(['max' => 100]) ],
            ])
            ->add('new', SubmitType::class, [ 'label' => 'Nový' ])
            ->add('choose', SubmitType::class, [ 'label' => 'Vybrat' ])
            ->add('rename', SubmitType::class, [ 'label' => 'Přejmenovat' ]);
        if($project->getAllowMultiplePlan()) $fb->add('duplicate', SubmitType::class, [ 'label' => 'Duplikovat' ]);
        if($project->getDefaultPlan()) $fb->add('defaultPlan', SubmitType::class, [ 'label' => 'Výchozí plán' ]);
        $form = $fb->getForm();

        if($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if($form->isValid() && $form->get('new')->isClicked()) {
                $data = $form->getData();
                if(method_exists(Entity\Plan::class, 'translate')) {
                    $res = $this->getDoctrine()->getRepository(Entity\Plan::class)
                            ->createQueryBuilder('p')
                            ->select('count(pt.id)')
                            ->leftJoin('p.translations', 'pt')
                            ->where('p.playersProject = :pp')->setParameter('pp', $pp)
                            ->andWhere('pt.name = :name')->setParameter('name', $data['name'])
                            ->getQuery()->getSingleScalarResult();
                    if(!empty($res)) $form->addError(new FormError($this->trans('Plán s tímto jménem již existuje.')));
                }
            }
            if($form->isValid()) {
                $data = $form->getData();
                if($form->get('new')->isClicked()) {
                    if(!$project->getAllowMultiplePlan()) {
                        $form->addError(new FormError($this->trans('Tento projekt nemá povolené vícenasobné plánování.')));
                    } else {
                        $plan = new Entity\Plan();
                        $plan->setPlayersProject($pp);
                        if(method_exists($plan, 'translate')) {
                            $plan->translate(\App\Config::getDefaultLocale())->setName($data['name'] ?: $defaultName);
                            $plan->mergeNewTranslations();
                        }
                        else $plan->setName($data['name'] ?: $defaultName);
                        $this->em->persist($plan);
                        $pp->setLastPlan($plan);
                        $this->em->flush();

                        $this->addFlash('success', $this->trans('Vytvořen nový plán.'));
                    }
                }
                elseif($form->get('choose')->isClicked()) {
                    $request->getSession()->set('plan', $data['plan']);
                    $pp->setLastPlan($data['plan']);
                    $this->em->flush();

                    return $this->redirectToRoute('app_plan_planning', ['plan' => $data['plan']->getId()]);
                }
                elseif($form->get('rename')->isClicked()) {
                    if(method_exists($data['plan'], 'translate')) {
                        $data['plan']->translate(\App\Config::getDefaultLocale())->setName($data['name'] ?: $defaultName);
                        $data['plan']->mergeNewTranslations();
                    }
                    else $data['plan']->setName($data['name'] ?: $defaultName);
                    $this->em->flush();
                    $this->addFlash('success', $this->trans('Plán přejmenován.'));
                }
                elseif($form->get('duplicate')->isClicked()) {
                    if (!$project->getAllowMultiplePlan()) {
                        $form->addError(new FormError($this->trans('Tento projekt nemá povolené vícenasobné plánování.')));
                    } else {
                        $this->em->getRepository(Entity\Plan::class)->duplicate($data['plan'], $defaultName);
                        $this->em->flush();
                        $this->addFlash('success', $this->trans('Plán zduplikován.'));
                    }
                }
                elseif($form->get('defaultPlan')->isClicked()) {
                    if(!empty($project->getDefaultPlan())) $form->addError(new FormError($this->trans('Tento projekt nemá výchozí plán.')));
                    else {
                        $name = $this->trans('Výchozí plán') .' '. $newPlanNum;
                        $this->em->getRepository(Entity\Plan::class)->duplicate($data['plan'], $name);
                        $this->em->flush();
                        $this->addFlash('success', $this->trans('Výchozí plán zduplikován.'));
                    }
                }
                if($form->isValid()) {
                    return $this->redirect($request->getRequestUri());
                }
            }
        }

        return $this->render('Plan\selectPlan.html.twig', [
            'currentProject' => $project,
            'currentPlan' => $request->getSession()->get('plan'),
            'pproject' => $pp,
            'playable' => $pp->getPlayable() - $pp->getPlayed(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route({
     *     "cs": "/{project}/srovnani-planu",
     *     "en": "/{project}/compare-plans"
     * }, requirements={"project": "\d+"})
     */
    public function comparePlans(LeftMenuManager $menu, Entity\Project $project): Response
    {
        $this->denyAccessUnlessGranted(ProjectVoter::PLAY, $project);
        $menu->markActive('comparePlans');
        return $this->render('Project\comparePlans.html.twig', [
            'project' => $project
        ]);
    }

    /**
     * @Route({
     *     "cs": "/{project}/vybrat-hru",
     *     "en": "/{project}/select-game"
     * }, requirements={"project": "\d+"})
     */
    public function selectGame(LeftMenuManager $menu, Entity\Project $project): Response
    {
        $this->denyAccessUnlessGranted(ProjectVoter::PLAY, $project);
        $menu->markActive('selectGame');
        return $this->render('Project\selectGame.html.twig', [
            'project' => $project
        ]);
    }

    /**
     * @Route({
     *     "cs": "/{project}/popis",
     *     "en": "/{project}/description"
     * }, requirements={"project": "\d+"})
     */
    public function description(LeftMenuManager $menu, Entity\Project $project)
    {
        $this->denyAccessUnlessGranted(ProjectVoter::PLAY, $project);
        $menu->markActive('projectDescription');
        $tplVars = [ 'project' => $project ];
        return $this->render('Project\description.html.twig', $tplVars);
    }

    /**
     * @Route({
     *     "cs": "/{project}/technologie",
     *     "en": "/{project}/technologies"
     * }, requirements={"project": "\d+"})
     * @Security("user.getAllowedProjects().contains(project)")
     */
    public function technologies(LeftMenuManager $menu, Entity\Project $project)
    {
        $this->denyAccessUnlessGranted(ProjectVoter::PLAY, $project);
        $menu->markActive('projectTechnologies');
        $tplVars = [ 'project' => $project ];
        return $this->render('Project\technologies.html.twig', $tplVars);
    }

    /**
     * @Route({
     *     "cs": "/{project}/cety",
     *     "en": "/{project}/teams"
     * }, requirements={"project": "\d+"})
     * @Security("user.getAllowedProjects().contains(project)")
     */
    public function teams(LeftMenuManager $menu, Entity\Project $project)
    {
        $this->denyAccessUnlessGranted(ProjectVoter::PLAY, $project);
        $menu->markActive('projectTeams');
        $tplVars = [ 'project' => $project ];
        return $this->render('Project\teams.html.twig', $tplVars);
    }

    /**
     * @Route({
     *     "cs": "/{project}/diskuze",
     *     "en": "/{project}/comments"
     * }, requirements={"project": "\d+"})
     * @Security("user.getAllowedProjects().contains(project)")
     */
    public function comments(LeftMenuManager $menu, Entity\Project $project)
    {
        $this->denyAccessUnlessGranted(ProjectVoter::PLAY, $project);
        $menu->markActive('projectComments');
        $tplVars = [ 'project' => $project ];
        return $this->render('Project\comments.html.twig', $tplVars);
    }
}