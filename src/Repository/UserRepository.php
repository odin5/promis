<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 11.07.2018
 * Time: 17:44
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository {
    public function getPresetForAllWasteOrNull($user = null) {
        $qb = $this->createQueryBuilder('p')//->select('p.id')
        ->leftJoin('p.wastePlusCodes','c')
            ->groupBy('p.id')->having('count(c.id) = 0')
            ->setMaxResults(1);
        if(is_null($user)) {
            $qb->where('p.user IS NULL');
        } else {
            $qb->where('p.user = :user')->setParameter('user', $user);
        }
        try {
            $result = $qb->getQuery()->getSingleResult();
        } catch(NoResultException $e) {
            return null;
        }
        return $result;
    }
    public function createPresetsForNewUserAndFlush(User $user) {
        $em = $this->getEntityManager();
        $defaultPresets = $this->findByUser(null);
        foreach($defaultPresets as $defaultPreset) {
            $newPreset = new UserWasteCodesPreset();
            $newPreset->setUser($user);
            $newPreset->setName($defaultPreset->getName());
            $em->persist($newPreset);
            foreach($defaultPreset->getWastePlusCodes() as $defaultCode) {
                $newCode = new UserWasteCodesPresetCode();
                $newCode->setWastePlusCode($defaultCode->getWastePlusCode());
                $newCode->setCoefficient($defaultCode->getCoefficient());
                $newCode->setPreset($newPreset);
                $em->persist($newCode);
            }
        }
        $em->flush();
    }
}
