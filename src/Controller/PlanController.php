<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 16.08.2018 17:34
 */

namespace App\Controller;

use App\Entity;
use App\Service\LeftMenuManager;
use App\Security\PlanVoter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlanController
 * @Route("/plan")
 */
class PlanController extends AbstractController
{
    /**
     * @Route({
     *     "cs": "/{plan}/planovani",
     *     "en": "/{plan}/planning"
     * }, requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function planning(LeftMenuManager $menu, Entity\Plan $plan): Response
    {
        $this->denyAccessUnlessGranted(PlanVoter::PLAY, $plan);
        $menu->markActive('planPlanning');
        return $this->render('plan/planning.html.twig', ['plan' => $plan]);
    }

    /**
     * @Route("/{plan}/gantt", requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gantt(LeftMenuManager $menu, Entity\Plan $plan): Response
    {
        $this->denyAccessUnlessGranted(PlanVoter::PLAY, $plan);
        $menu->markActive('planGantt');
        return $this->render('plan/gantt.html.twig', ['plan' => $plan]);
    }

    /**
     * @Route("/{plan}/cashflow", requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cashflow(LeftMenuManager $menu, Entity\Plan $plan): Response
    {
        $this->denyAccessUnlessGranted(PlanVoter::PLAY, $plan);
        $menu->markActive('planCashflow');
        return $this->render('plan/cashflow.html.twig', ['plan' => $plan]);
    }

    /**
     * @Route({
     *     "cs": "/{plan}/naklady",
     *     "en": "/{plan}/expenses"
     * }, requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function expenses(LeftMenuManager $menu, Entity\Plan $plan): Response
    {
        $this->denyAccessUnlessGranted(PlanVoter::PLAY, $plan);
        $menu->markActive('planExpenses');
        return $this->render('plan/expenses.html.twig', ['plan' => $plan]);
    }

    /**
     * @Route({
     *     "cs": "/{plan}/validace",
     *     "en": "/{plan}/validation"
     * }, requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validation(LeftMenuManager $menu, Entity\Plan $plan): Response
    {
        $this->denyAccessUnlessGranted(PlanVoter::PLAY, $plan);
        $menu->markActive('planValidation');
        return $this->render('plan/validation.html.twig', ['plan' => $plan]);
    }
}