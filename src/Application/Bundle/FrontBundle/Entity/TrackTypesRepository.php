<?php

namespace Application\Bundle\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TrackTypesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrackTypesRepository extends EntityRepository
{
    public function getAllAsArray()
    {
        $names = $this->getEntityManager()->createQuery('SELECT distinct(trackTypes.name)'
                . ' from ApplicationFrontBundle:TrackTypes trackTypes'
                )->getScalarResult();
        $tt = array_map("current",$names);

        return $tt;
    }
}
