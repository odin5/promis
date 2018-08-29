<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 22.08.2018 11:20
 */

namespace App\Repository;


use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

/**
 * Class BaseRepository is set up as default repository class in Doctrine config and is meant to be parent of all custom
 * repositories in the app.
 * @package App\Repository
 */
class BaseRepository extends EntityRepository
{
    /**
     * @param $criteria array|Criteria
     * @return int
     */
    public function countBy($criteria)
    {
        $persister = $this->getEntityManager()->getUnitOfWork()->getEntityPersister($this->_entityName);
        return $persister->count($criteria);
    }
}