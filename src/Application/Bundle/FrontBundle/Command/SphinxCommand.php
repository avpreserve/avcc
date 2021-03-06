<?php

/**
 * AVCC
 * 
 * @category AVCC
 * @package  Application
 * @author   Nouman Tayyab <nouman@weareavp.com>
 * @author   Rimsha Khalid <rimsha@weareavp.com>
 * @license  AGPLv3 http://www.gnu.org/licenses/agpl-3.0.txt
 * @copyright Audio Visual Preservation Solutions, Inc
 * @link     http://avcc.weareavp.com
 */

namespace Application\Bundle\FrontBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Application\Bundle\FrontBundle\SphinxSearch\SphinxSearch;

class SphinxCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('avcc:sphinx')
                ->setDescription('Insert all records in sphinx')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $shpinxInfo = $this->getSphinxInfo();

        $records = $em->getRepository('ApplicationFrontBundle:Records')->findAll();        
        foreach ($records as $record) {
            $recordId = $record->getId();
            $sphinxSearch = new SphinxSearch($em, $shpinxInfo, $recordId, $record->getMediaType()->getId());
            $result = $sphinxSearch->replace();
            if ($result == false) {
                $output->writeln("Record Not Inserted -- " . $recordId);
            } else {
                $output->writeln("Updated record -- " . $recordId);
            }
        }
        exit;
    }

    /**
     * Get sphinx parameters
     *
     * @return array
     */
    protected function getSphinxInfo() {
        return $this->getContainer()->getParameter('sphinx_param');
    }

}
