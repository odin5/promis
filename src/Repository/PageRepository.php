<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 */

namespace App\Repository;

use App\Entity\Page;
use Doctrine\ORM\NoResultException;

class PageRepository extends BaseRepository
{

    public function findOneForAppPage(string $controllerActionFullyQualifiedOrSpecialKey): ?Page
    {
        try {
            $result = $this->createQueryBuilder('p')
                ->where('p.appPages LIKE :action')
                ->setParameter('action', "%". addslashes($controllerActionFullyQualifiedOrSpecialKey) ."%")
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
        } catch(NoResultException $e) {
            return null;
        }
        return $result;
    }
}
