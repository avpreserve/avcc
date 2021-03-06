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
namespace Application\Bundle\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\Bundle\FrontBundle\Entity\ReelDiameters;
use Application\Bundle\FrontBundle\Form\ReelDiametersType;
/**
 * ReelDiameters controller.
 *
 * @Route("/vocabularies/reeldiameters")
 */
class ReelDiametersController extends Controller
{

    /**
     * Lists all ReelDiameters entities.
     *
     * @Route("/", name="vocabularies_reeldiameters")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ApplicationFrontBundle:ReelDiameters')->findBy(array(), array('order' => 'ASC'));

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ReelDiameters entity.
     *
     * @param Request $request
     *
     * @Route("/", name="vocabularies_reeldiameters_create")
     * @Method("POST")
     * @Template("ApplicationFrontBundle:ReelDiameters:new.html.twig")
     * @return array
     */
    public function createAction(Request $request)
    {
        $entity = new ReelDiameters();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isValid()) {
            $postedValue = $this->get('request')->request->get('application_bundle_frontbundle_reeldiameters');
            $f = $form->getData();
            if (isset($postedValue['reelFormat'])) {
                foreach ($postedValue['reelFormat'] as $key => $value) {
                    $entity = new ReelDiameters();
                    $entity->setName($f->getName());
                    $format = $this->getDoctrine()->getRepository('ApplicationFrontBundle:Formats')->find($value);
                    $entity->setReelFormat($format);
                    $em->persist($entity);
                    $em->flush();
                }
            } else {
                $em->persist($entity);
                $em->flush();
            }
            $this->get('session')->getFlashBag()->add('success', 'Reel diameter added succesfully.');

            return $this->redirect($this->generateUrl('vocabularies_reeldiameters'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ReelDiameters entity.
     *
     * @param ReelDiameters $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ReelDiameters $entity)
    {
        $form = $this->createForm(new ReelDiametersType(), $entity, array(
            'action' => $this->generateUrl('vocabularies_reeldiameters_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ReelDiameters entity.
     *
     * @Route("/new", name="vocabularies_reeldiameters_new")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function newAction()
    {
        $entity = new ReelDiameters();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a ReelDiameters entity.
     *
     * @param integer $id
     *
     * @Route("/{id}", name="vocabularies_reeldiameters_show")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationFrontBundle:ReelDiameters')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReelDiameters entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ReelDiameters entity.
     *
     * @param integer $id
     *
     * @Route("/{id}/edit", name="vocabularies_reeldiameters_edit")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationFrontBundle:ReelDiameters')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReelDiameters entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a ReelDiameters entity.
     *
     * @param ReelDiameters $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ReelDiameters $entity)
    {
        $form = $this->createForm(new ReelDiametersType(), $entity, array(
            'action' => $this->generateUrl('vocabularies_reeldiameters_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing ReelDiameters entity.
     *
     * @param Request $request
     * @param integer $id
     *
     * @Route("/{id}", name="vocabularies_reeldiameters_update")
     * @Method("PUT")
     * @Template("ApplicationFrontBundle:ReelDiameters:edit.html.twig")
     * @return array
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationFrontBundle:ReelDiameters')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReelDiameters entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Reel diameter updated succesfully.');

            return $this->redirect($this->generateUrl('vocabularies_reeldiameters_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ReelDiameters entity.
     *
     * @param Request $request
     * @param integer $id
     *
     * @Route("/{id}", name="vocabularies_reeldiameters_delete")
     * @Method("DELETE")
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ApplicationFrontBundle:ReelDiameters')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ReelDiameters entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vocabularies_reeldiameters'));
    }

    /**
     * Creates a form to delete a ReelDiameters entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('vocabularies_reeldiameters_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                         ->add('submit', 'submit', array('label' => 'Delete','attr' => array('onclick' => "return confirm('Are you sure you want to delete selected term?')")))
                        ->getForm();
    }
    
    /**
     * update field order
     *
     * @param Request $request
     *
     * @Route("/fieldOrder", name="reelDia_update_order")
     * @Method("POST")
     * @return array
     */
    public function updateFieldOrder(Request $request) {
        // code to update
        $adsIds = $this->get('request')->request->get('rd_ids');
        $count = 0;
        foreach ($adsIds as $ads) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ApplicationFrontBundle:ReelDiameters')->find($ads);
            if ($entity) {
                $entity->setOrder($count);
               // $em->persist($entity);
                $em->flush();
                $count = $count + 1;
            }
        }
        echo json_encode(array('success' => 'true'));
        exit;
    }

}
