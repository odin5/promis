<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 */

namespace App\Repository;

use App\Entity;
use Doctrine\ORM\NoResultException;

class PlanRepository extends BaseRepository
{
    public function countPlansOfUser(Entity\User $user) {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->leftJoin('p.playersProject', 'pp')
            ->where('pp.player = :user')->setParameter('user', $user)
            ->getQuery()->getSingleScalarResult();
    }

    public function duplicate(Entity\Plan $plan, $newName) {
        $em = $this->getEntityManager();
        $newPlan = clone $plan; // https://stackoverflow.com/a/9071208
        $em->persist($newPlan);
        if(method_exists($newPlan, 'translate')) {
            $newPlan->translate(\App\Config::getDefaultLocale())->setName($newName);
            $newPlan->mergeNewTranslations();
        }
        else $newPlan->setName($newName);
        foreach([Entity\Loan::class, Entity\PlanSlotTeam::class, Entity\WorkStart::class] as $entity) {
            foreach($em->getRepository($entity)->findBy(['plan' => $plan]) as $associated) {
                $newAssoc = clone $associated;
                $newAssoc->setPlan($newPlan);
                $em->persist($newAssoc);
            }
        }
    }
}
