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
 * SlidesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SlidesRepository extends EntityRepository
{
    public function getAllAsArray()
    {
        $names = $this->getEntityManager()->createQuery('SELECT distinct(slides.name)'
                . ' from ApplicationFrontBundle:Slides slides'
                )->getScalarResult();
        $slides = array_map("current",$names);

        return $slides;
    }
}
