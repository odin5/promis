<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 16.07.2018
 * Time: 9:38
 */

namespace App\Service;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity;
use Doctrine\Common\Persistence\ObjectManager;

class PlanningManager
{
    private $em;
    private $iriConverter;

    public function __construct(ObjectManager $em, IriConverterInterface $iriConverter)
    {
        $this->em = $em;
        $this->iriConverter = $iriConverter;
    }


    public function getPlanSlots(Entity\Plan $plan)
    {
        $slots = $map = [];
        $pst = $this->em->getRepository(Entity\PlanSlotTeam::class)->findBy(['plan' => $plan]);
        foreach($pst as $item) {
            $map[$item->getWork()->getId()][$item->getTurn()->getId()][] = [
                'team' => $this->iriConverter->getIriFromItem($item->getTeam()),
                'count' => $item->getCount()
            ];
        }

        $project = $plan->getPlayersProject()->getProject();
        foreach($this->em->getRepository(Entity\Work::class)->findBy(['project' => $project]) as $work) {
            foreach($this->em->getRepository(Entity\Turn::class)->findBy(['project' => $project]) as $turn) {
                $slot = new \App\Api\Dto\PlanSlotDto();
                $slot->setPlan($this->iriConverter->getIriFromItem($plan))
                    ->setWork($this->iriConverter->getIriFromItem($work))
                    ->setTurn($this->iriConverter->getIriFromItem($turn));
                if(!empty($map[$work->getId()][$turn->getId()])) $slot->addTeamCount($map[$work->getId()][$turn->getId()]);
                $slots[] = $slot;
            }
        }

        return $slots;
    }
}