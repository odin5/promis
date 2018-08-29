<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 22:20
 */
namespace App\Api\Controller;

use App\Api\Dto\PlanningDto;
use App\Api\Dto\PlanSlotDto;
use App\Controller\AbstractController;
use App\Service\PlanningManager;
use App\Entity;
use Symfony\Component\HttpFoundation\Request;

class PlanController extends AbstractController
{
    public function getPlanning(Entity\Plan $plan, PlanningManager $manager)
    {
        $project = $plan->getPlayersProject()->getProject();
        $planning = new PlanningDto();
        $planning
            ->setPlan($plan)
            ->setWorks($this->em->getRepository(Entity\Work::class)->findBy(['project' => $project]))
            ->setTurns($this->em->getRepository(Entity\Turn::class)->findBy(['project' => $project]))
            ->setTeams($this->em->getRepository(Entity\Team::class)->findBy(['project' => $project]))
            ->setWeathers($this->em->getRepository(Entity\Weather::class)->findBy(['project' => $project]))
            ->setPlanSlots($manager->getPlanSlots($plan));
        return $planning;
    }

    public function getSlots(Entity\Plan $plan, PlanningManager $manager)
    {
        return $manager->getPlanSlots($plan);
    }
}