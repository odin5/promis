<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 10.07.2018
 * Time: 18:01
 */

namespace App\Controller;

use App\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController
 * @Route({
 *     "cs": "/hra",
 *     "en": "/game"
 * })
 */
class GameController extends AbstractController
{

    /**
     * @Route({
     *     "cs": "/{plan}/prehled",
     *     "en": "/{plan}/overview"
     * }, requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function overview(Entity\Plan $plan): Response
    {
        return $this->render('game/overview.html.twig', ['currentPlan' => $plan]);
    }

    /**
     * @Route({
     *     "cs": "/{plan}/planovani",
     *     "en": "/{plan}/planning"
     * }, requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function planning(Entity\Plan $plan): Response
    {
        return $this->render('game/planning.html.twig', ['currentPlan' => $plan]);
    }

    /**
     * @Route("/{plan}/gantt", requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gantt(Entity\Plan $plan): Response
    {
        return $this->render('game/gantt.html.twig', ['currentPlan' => $plan]);
    }

    /**
     * @Route("/{plan}/cashflow", requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cashflow(Entity\Plan $plan): Response
    {
        return $this->render('game/cashflow.html.twig', ['currentPlan' => $plan]);
    }

    /**
     * @Route({
     *     "cs": "/{plan}/naklady",
     *     "en": "/{plan}/expenses"
     * }, requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function expenses(Entity\Plan $plan): Response
    {
        return $this->render('game/expenses.html.twig', ['currentPlan' => $plan]);
    }

    /**
     * @Route({
     *     "cs": "/{plan}/validace",
     *     "en": "/{plan}/validation"
     * }, requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validation(Entity\Plan $plan): Response
    {
        return $this->render('game/validation.html.twig', ['currentPlan' => $plan]);
    }

    /**
     * @Route({
     *     "cs": "/{plan}/vyjednavat",
     *     "en": "/{plan}/interrogate"
     * }, requirements={"plan": "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function interrogate(Entity\Plan $plan): Response
    {
        return $this->render('game/validation.html.twig', ['currentPlan' => $plan]);
    }
}