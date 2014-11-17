<?php

namespace Application\Bundle\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RecordsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecordsRepository extends EntityRepository
{

    public function findAllRecords($offSet = 0, $limit = 100, $col = 'r.id', $order = 'asc')
    {
        $result = $this->getEntityManager()->createQuery("SELECT r as record,m.id as mediaTypeId,m.name as mediaType,p.name as projectTitle"
                                . " FROM ApplicationFrontBundle:Records r"
                                . " JOIN ApplicationFrontBundle:MediaTypes m WITH r.mediaType = m.id"
                                . " JOIN ApplicationFrontBundle:Projects p WITH r.project = p.id"
                                . " order by r.id $order"
                        )
//                        ->setMaxResults($limit)
//                        ->setFirstResult($offSet)
                        ->getArrayResult();
        
        
        return $result;
    }

    public function findAudioRecordById($id)
    {
        return $this->getEntityManager()->createQuery("SELECT r as record, ar as audio, m.name as mediaType, p.name as projectTitle"
                                . " FROM ApplicationFrontBundle:Records r"
                                . " JOIN ApplicationFrontBundle:MediaTypes m WITH r.mediaType = m.id"
                                . " JOIN ApplicationFrontBundle:Projects p WITH r.project = p.id"
                                . " JOIN ApplicationFrontBundle:AudioRecords ar WITH ar.record = r.id "
                                . " Where r.id = $id"
                        )
                        ->getArrayResult();
    }

}
