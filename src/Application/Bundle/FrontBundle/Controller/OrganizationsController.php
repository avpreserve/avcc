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
namespace Application\Bundle\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\Bundle\FrontBundle\Entity\Organizations;
use Application\Bundle\FrontBundle\Entity\Users;
use Application\Bundle\FrontBundle\Entity\Projects;
use Application\Bundle\FrontBundle\Form\OrganizationsType;
use Application\Bundle\FrontBundle\Entity\Records;
use Application\Bundle\FrontBundle\SphinxSearch\SphinxSearch;

/**
 * Organizations controller.
 *
 * @Route("/organizations")
 */
class OrganizationsController extends Controller {

    /**
     * Lists all Organizations entities.
     *
     * @Route("/", name="organizations")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $entities = $em->getRepository('ApplicationFrontBundle:Organizations')->findAll();
        } else {
            $entities = $em->getRepository('ApplicationFrontBundle:Organizations')->findBy(array('id' => $this->getUser()->getOrganizations()->getId()));
        }

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Organizations entity.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request form data variable
     *
     * @Route("/", name="organizations_create")
     * @Method("POST")
     * @Template("ApplicationFrontBundle:Organizations:new.html.twig")
     * @return array
     */
    public function createAction(Request $request) {
        $user = $this->getUser();
        $entity = new Organizations();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUsersCreated($user);
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Organization added succesfully.');

            return $this->redirect($this->generateUrl('organizations'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Organizations entity.
     *
     * @param Organizations $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Organizations $entity) {
        $form = $this->createForm(new OrganizationsType(), $entity, array(
            'action' => $this->generateUrl('organizations_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Organizations entity.
     *
     * @Route("/new", name="organizations_new")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function newAction() {
        $entity = new Organizations();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Organizations entity.
     *
     * @param integer $id organization id
     *
     * @Route("/{id}", name="organizations_show")
     * @Method("GET")
     * @Template()     *
     *
     * @return array
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationFrontBundle:Organizations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organizations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Organizations entity.
     *
     * @param integer $id organization id
     *
     * @Route("/{id}/edit", name="organizations_edit")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationFrontBundle:Organizations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organizations entity.');
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
     * Creates a form to edit a Organizations entity.
     *
     * @param Organizations $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Organizations $entity) {
        $form = $this->createForm(new OrganizationsType(), $entity, array(
            'action' => $this->generateUrl('organizations_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Organizations entity.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request form data variable
     * @param integer                                   $id      organization id
     *
     * @Route("/{id}", name="organizations_update")
     * @Method("PUT")
     * @Template("ApplicationFrontBundle:Organizations:edit.html.twig")
     *
     * @return array
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $entity = $em->getRepository('ApplicationFrontBundle:Organizations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organizations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUsersUpdated($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Organization updated succesfully.');

            return $this->redirect($this->generateUrl('organizations'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Organizations entity.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request form data variable
     * @param integer                                   $id      organization id
     *
     * @Route("/{id}", name="organizations_delete")
     * @Method("DELETE")
     *
     *
     * @return redirect to organization list page
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ApplicationFrontBundle:Organizations')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Organizations entity.');
            }
            $records = $em->getRepository('ApplicationFrontBundle:Users')->findBy(array('organization'=> $id));
            foreach ($records as $user) {
                $record = $em->getRepository('ApplicationFrontBundle:Records')->findBy(array('user'=> $user->getId()));
                $shpinxInfo = $this->container->getParameter('sphinx_param');
                $sphinxSearch = new SphinxSearch($em, $shpinxInfo, $record->getId(), $record->getMediaType()->getId());
                $sphinxSearch->delete();
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('organizations'));
    }

    /**
     * Creates a form to delete a Organizations entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('organizations_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('onclick' => "return confirm('Are you sure you want to delete selected organization?')")))
                        ->getForm();
    }

    /**
     * Active/Inactive organization.
     *
     * @param integer $id User id
     * @param integer $status User status id
     * 
     * @Route("/changestatus/{id}/{status}", name="organization_changestatus")
     * @Method("GET")
     * @Template()
     * @return redirection
     */
    public function changeStatusAction($id, $status) {
        $em = $this->getDoctrine()->getManager();
        $organization = $em->getRepository('ApplicationFrontBundle:Organizations')->find($id);
        if ($status == 1) {
            $organization->setStatus(0);
            $users = $em->getRepository('ApplicationFrontBundle:Users')->findBy(array('organizations' => $id));

            foreach ($users as $user) {
                $_user = $em->getRepository('ApplicationFrontBundle:Users')->find($user->getId());
                $_user->setEnabled(0);
            }
            
            $projects = $em->getRepository('ApplicationFrontBundle:Projects')->findBy(array('organization' => $id));
            foreach ($projects as $project) {
                $_user = $em->getRepository('ApplicationFrontBundle:Projects')->find($project->getId());
                $_user->setStatus(0);
            }
            $this->get('session')->getFlashBag()->add('success', 'Organization disabled succesfully.');
        } else {
            $organization->setStatus(1);
            $users = $em->getRepository('ApplicationFrontBundle:Users')->findBy(array('organizations' => $id));
            foreach ($users as $user) {
                $_user = $em->getRepository('ApplicationFrontBundle:Users')->find($user->getId());
                $_user->setEnabled(1);
            }
            $projects = $em->getRepository('ApplicationFrontBundle:Projects')->findBy(array('organization' => $id));
            foreach ($projects as $project) {
                $_user = $em->getRepository('ApplicationFrontBundle:Projects')->find($project->getId());
                $_user->setStatus(1);
            }
            $this->get('session')->getFlashBag()->add('success', 'Organization activated succesfully.');
        }
        $em->flush();
        return $this->redirect($this->generateUrl('organizations'));
    }

}
