<?php
/**
 * AVCC
 * 
 * @category AVCC
 * @package  Application
 * @author   Nouman Tayyab <nouman@avpreserve.com>
 * @author   Rimsha Khalid <rimsha@avpreserve.com>
 * @license  AGPLv3 http://www.gnu.org/licenses/agpl-3.0.txt
 * @copyright Audio Visual Preservation Solutions, Inc
 * @link     http://avcc.avpreserve.com
 */
namespace Application\Bundle\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FrameRatesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FrameRatesRepository extends EntityRepository
{
    public function getAllAsArray()
    {
        $names = $this->getEntityManager()->createQuery('SELECT distinct(frameRates.name)'
                . ' from ApplicationFrontBundle:FrameRates frameRates'
                )->getScalarResult();
        $frameRates = array_map("current",$names);

        return $frameRates;
    }
}
