<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 */

namespace App\Repository;

use App\Entity\Work;
use Doctrine\ORM\NoResultException;

class WorkRepository extends BaseRepository
{
    public function isWorkCumulativa(Work $work)
    {
        return $this->findOneBy(['cumulative' => $work]) !== null;
    }

    public function getLastCumulative(Work $work)
    { // a.k.a get root work of cumulation chain containing this work
        for($i = 0; $i < 1000 && $work !== null; $i++) {
            $work = $this->findOneBy(['cumulative' => $work]);
        }
        return $work;
    }
}
