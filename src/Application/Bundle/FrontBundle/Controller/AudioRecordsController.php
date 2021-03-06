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
use Application\Bundle\FrontBundle\Entity\AudioRecords;
use Application\Bundle\FrontBundle\Form\AudioRecordsType;
use Application\Bundle\FrontBundle\Helper\DefaultFields as DefaultFields;
use Application\Bundle\FrontBundle\SphinxSearch\SphinxSearch;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Application\Bundle\FrontBundle\Entity\Projects;
use Application\Bundle\FrontBundle\Entity\Records;
use Application\Bundle\FrontBundle\Controller\MyController;

/**
 * AudioRecords controller.
 *
 * @Route("/record")
 */
class AudioRecordsController extends MyController {

    /**
     * Lists all AudioRecords entities.
     *
     * @Route("/", name="record")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function indexAction() {
        $session = $this->getRequest()->getSession();
        if (($session->has('termsStatus') && $session->get('termsStatus') == 0) || ($session->has('limitExceed') && $session->get('limitExceed') == 0)) {
            return $this->redirect($this->generateUrl('dashboard'));
        }
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ApplicationFrontBundle:Records')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new AudioRecords entity.
     *
     * @param Request $request
     *
     * @Route("/audio/", name="record_create")
     * @Method("POST")
     * @Template("ApplicationFrontBundle:AudioRecords:new.html.php")
     * @return array
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $fieldsObj = new DefaultFields();
        $data = $fieldsObj->getData(1, $em, $this->getUser(), null);
        $entity = new AudioRecords();
        $form = $this->createCreateForm($entity, $em, $data);
        $form->handleRequest($request);
        $error = '';
        $result = $this->checkUniqueId($request);

        if ($result != '') {
            $error = new FormError("The unique ID must be unique.");
            $form->get('record')->get('uniqueId')->addError($error);
        }
        if ($form->isValid()) {

            $em->persist($entity);
            try {
                $em->flush();
                if (!empty($request->files->get('files'))) {
                    $this->get('application_front.photo_uploader')->upload($request->files->get('files'), $entity->getRecord()->getId());
                }
                $shpinxInfo = $this->getSphinxInfo();
                $sphinxSearch = new SphinxSearch($em, $shpinxInfo, $entity->getRecord()->getId(), 1);
                $sphinxSearch->insert();
                $this->get('session')->getFlashBag()->add('success', 'Audio record added succesfully.');
                $this->get('session')->set('project_id', $entity->getRecord()->getProject()->getId());

                if (!in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles()) && $this->getUser()->getOrganizations() && ($form->get('save_and_duplicate')->isClicked() || $form->get('save_and_new')->isClicked()) && $this->container->getParameter("enable_stripe")) {
                    $paidOrg = $fieldsObj->paidOrganizations($this->getUser()->getOrganizations()->getId(), $em);
                    if ($paidOrg || is_array($paidOrg)) {
                        $org_records = $em->getRepository('ApplicationFrontBundle:Records')->countOrganizationRecords($this->getUser()->getOrganizations()->getId());
                        $counter = $org_records['total'];
                        $plan_limit = 2500;
                        $plan_id = "";
                        $creator = $this->getUser()->getOrganizations()->getUsersCreated();
                        if (in_array("ROLE_ADMIN", $creator->getRoles())) {
                            $plan_id = $creator->getStripePlanId();
                        }
                        if ($plan_id != NULL && $plan_id != "") {
                            $plan = $em->getRepository('ApplicationFrontBundle:Plans')->findBy(array("planId" => $plan_id));
                            $plan_limit = $plan[0]->getRecords();
                        }
                        if ($counter == $plan_limit) {
                            return $this->redirect($this->generateUrl('record_list_withdialog', array('dialog' => 1)));
                        }
                    }
                }
                // the save_and_dupplicate button was clicked
                if ($form->get('save_and_duplicate')->isClicked()) {
                    return $this->redirect($this->generateUrl('record_audio_duplicate', array('audioRecId' => $entity->getId())));
                }
                if ($form->get('save_and_new')->isClicked()) {
                    return $this->redirect($this->generateUrl('record_new', array('audioRecId' => $entity->getId())));
                }
                return $this->redirect($this->generateUrl('record_list'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                
            }
        }
        if ($this->get('session')->get('project_id')) {
            $projectId = $this->get('session')->get('project_id');
        } else if ($entity->getRecord()->getProject()->getId()) {
            $projectId = $entity->getRecord()->getProject()->getId();
        }
        $allowed_upload = "";
        if ($projectId) {
            $allowed_upload = true;
            $project = $em->getRepository('ApplicationFrontBundle:Projects')->findOneBy(array('id' => $projectId));
            if ($project->getViewSetting() != null) {
                $defSettings = $fieldsObj->getDefaultOrder();
                $dbSettings = $project->getViewSetting();
                $userViewSettings = $fieldsObj->fields_cmp(json_decode($defSettings, true), json_decode($dbSettings, true));
            } else {
                $userViewSettings = $fieldsObj->getDefaultOrder();
            }
            $organization = $em->getRepository('ApplicationFrontBundle:Organizations')->find($project->getOrganization()->getId());
            $creator = $organization->getUsersCreated();
            $customerId = $creator->getStripeCustomerId();
            if ($organization->getIsPaid() != 1 || $customerId == "" || $customerId == null) {
                $allowed_upload = false;
            }
        } else {
            $userViewSettings = $fieldsObj->getDefaultOrder();
        }
        $userViewSettings = json_decode($userViewSettings, true);
        $tooltip = $fieldsObj->getToolTip(1);

        $allErrors = $this->allFormErrors($form);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'type' => $data['mediaType']->getName(),
            'fieldSettings' => $userViewSettings,
            'allErrors' => $allErrors,
            'tooltip' => $tooltip,
            'allowed_upload' => $allowed_upload
        );
    }

    /**
     * Creates a form to create a AudioRecords entity.
     *
     * @param AudioRecords  $entity The entity
     * @param EntityManager $em
     * @param form          $data
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AudioRecords $entity, $em, $data = null) {
        $form = $this->createForm(new AudioRecordsType($em, $data), $entity, array(
            'action' => $this->generateUrl('record_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Save'));
        $form->add('save_and_new', 'submit', array('label' => 'Save & New'));
        $form->add('save_and_duplicate', 'submit', array('label' => 'Save & Duplicate'));

        return $form;
    }

    /**
     * Displays a form to create a new AudioRecords entity.
     *
     * @param integer $projectId
     * @param integer $audioRecId
     *
     * @Route("/audio/new", name="record_new")
     * @Route("/audio/new/{projectId}", name="record_new_against_project")
     * @Route("/audio/new/{audioRecId}/duplicate", name="record_audio_duplicate")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function newAction($projectId = null, $audioRecId = null) {
        $session = $this->getRequest()->getSession();
        if (($session->has('termsStatus') && $session->get('termsStatus') == 0) || ($session->has('limitExceed') && $session->get('limitExceed') == 0)) {
            return $this->redirect($this->generateUrl('dashboard'));
        }
        if (false === $this->get('security.context')->isGranted('ROLE_CATALOGER')) {
            throw new AccessDeniedException('Access Denied.');
        }
        $em = $this->getDoctrine()->getManager();


        $fieldsObj = new DefaultFields();
        $userViewSettings = $fieldsObj->getDefaultOrder();
        $data = $fieldsObj->getData(1, $em, $this->getUser(), $projectId);
        if ($audioRecId) {
            $entity = $em->getRepository('ApplicationFrontBundle:AudioRecords')->find($audioRecId);
            $entity->getRecord()->setUniqueId(NULL);
            $entity->getRecord()->setLocation(NULL);
            $entity->getRecord()->setTitle(NULL);
            $entity->getRecord()->setDescription(NULL);
            $entity->getRecord()->setContentDuration(NULL);
            $entity->setMediaDuration(NULL);
            $entity->getRecord()->setCreationDate(NULL);
            $entity->getRecord()->setContentDate(NULL);
            $entity->getRecord()->setIsReview(NULL);
            $entity->setSlides(NULL);
            $entity->setTrackTypes(NULL);
            $entity->setMonoStereo(NULL);
            $entity->setNoiceReduction(NULL);
            $entity->getRecord()->setGenreTerms(NULL);
            $entity->getRecord()->setContributor(NULL);
            $entity->getRecord()->setGeneration(NULL);
            $entity->getRecord()->setPart(NULL);
            $entity->getRecord()->setDuplicatesDerivatives(NULL);
            $entity->getRecord()->setRelatedMaterial(NULL);
            $entity->getRecord()->setConditionNote(NULL);
        } else {
            $entity = new AudioRecords();
        }
        $form = $this->createCreateForm($entity, $em, $data);
        $allowed_upload = "";
        if ($projectId || $this->get('session')->get('project_id')) {
            $allowed_upload = true;
            if ($projectId == null && $this->get('session')->get('project_id')) {
                $projectId = $this->get('session')->get('project_id');
            }
            $project = $em->getRepository('ApplicationFrontBundle:Projects')->findOneBy(array('id' => $projectId));
            if ($project->getViewSetting() != null) {
                $defSettings = $fieldsObj->getDefaultOrder();
                $dbSettings = $project->getViewSetting();
                $userViewSettings = $fieldsObj->fields_cmp(json_decode($defSettings, true), json_decode($dbSettings, true));
            } else {
                $userViewSettings = $fieldsObj->getDefaultOrder();
            }
            $organization = $em->getRepository('ApplicationFrontBundle:Organizations')->find($project->getOrganization()->getId());
            $creator = $organization->getUsersCreated();
            $customerId = $creator->getStripeCustomerId();
            if ($organization->getIsPaid() != 1 || $customerId == "" || $customerId == null) {
                $allowed_upload = false;
            }
        }
        $userViewSettings = json_decode($userViewSettings, true);
        $tooltip = $fieldsObj->getToolTip(1);
        return $this->render('ApplicationFrontBundle:AudioRecords:new.html.php', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'fieldSettings' => $userViewSettings,
                    'type' => $data['mediaType']->getName(),
                    'allErrors' => array(),
                    'tooltip' => $tooltip,
                    'allowed_upload' => $allowed_upload
        ));
    }

    /**
     * Finds and displays a AudioRecords entity.
     *
     * @param integer $id
     *
     * @Route("/{id}", name="record_show")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function showAction($id) {
        $session = $this->getRequest()->getSession();
        if (($session->has('termsStatus') && $session->get('termsStatus') == 0) || ($session->has('limitExceed') && $session->get('limitExceed') == 0)) {
            return $this->redirect($this->generateUrl('dashboard'));
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationFrontBundle:AudioRecords')->findOneBy(array('record' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AudioRecords entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        $fieldsObj = new DefaultFields();
        $userViewSettings = $fieldsObj->getFieldSettings($this->getUser(), $em);

        return $this->render('ApplicationFrontBundle:AudioRecords:show.html.php', array(
                    'entity' => $entity,
                    //   'delete_form' => $deleteForm->createView(),
                    'fieldSettings' => $userViewSettings
        ));
    }

    /**
     * Displays a form to edit an existing AudioRecords entity.
     *
     * @param integer $id
     * @param integer $projectId
     *
     * @Route("/{id}/edit", name="record_edit")
     * @Route("/{id}/edit/{projectId}", name="record_edit_against_project")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function editAction($id, $projectId = null) {
        $session = $this->getRequest()->getSession();
        if (($session->has('termsStatus') && $session->get('termsStatus') == 0) || ($session->has('limitExceed') && $session->get('limitExceed') == 0)) {
            return $this->redirect($this->generateUrl('dashboard'));
        }
        if (false === $this->get('security.context')->isGranted('ROLE_CATALOGER')) {
            throw new AccessDeniedException('Access Denied.');
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ApplicationFrontBundle:AudioRecords')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AudioRecords entity.');
        }
        $fieldsObj = new DefaultFields();
        $userViewSettings = $fieldsObj->getDefaultOrder();
        $data = $fieldsObj->getData(1, $em, $this->getUser(), null, $entity->getRecord()->getId());

        $editForm = $this->createEditForm($entity, $em, $data);
        //  $deleteForm = $this->createDeleteForm($id);
        if ($projectId) {
            $project = $em->getRepository('ApplicationFrontBundle:Projects')->findOneBy(array('id' => $projectId));
            if ($project->getViewSetting() != null) {
//                $userViewSettings = $project->getViewSetting();
                $defSettings = $fieldsObj->getDefaultOrder();
                $dbSettings = $project->getViewSetting();
                $userViewSettings = $fieldsObj->fields_cmp(json_decode($defSettings, true), json_decode($dbSettings, true));
            } else {
                $userViewSettings = $fieldsObj->getDefaultOrder();
            }
        } else if ($entity->getRecord()->getProject()->getViewSetting()) {
//            $userViewSettings = $entity->getRecord()->getProject()->getViewSetting();
            $defSettings = $fieldsObj->getDefaultOrder();
            $dbSettings = $entity->getRecord()->getProject()->getViewSetting();
            $userViewSettings = $fieldsObj->fields_cmp(json_decode($defSettings, true), json_decode($dbSettings, true));
        }

        $userViewSettings = json_decode($userViewSettings, true);
        $images = $em->getRepository('ApplicationFrontBundle:RecordImages')->findBy(array('recordId' => $entity->getRecord()->getId()));
        $tooltip = $fieldsObj->getToolTip(1);
        return $this->render('ApplicationFrontBundle:AudioRecords:edit.html.php', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    //   'delete_form' => $deleteForm->createView(),
                    'fieldSettings' => $userViewSettings,
                    'type' => $data['mediaType']->getName(),
                    'allErrors' => array(),
                    'tooltip' => $tooltip,
                    'images' => $images
        ));
    }

    /**
     * Creates a form to edit a AudioRecords entity.
     *
     * @param AudioRecords  $entity The entity
     * @param EntityManager $em
     * @param array         $data
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(AudioRecords $entity, $em, $data = null) {
        $form = $this->createForm(new AudioRecordsType($em, $data), $entity, array(
            'action' => $this->generateUrl('record_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));
        $form->add('save_and_new', 'submit', array('label' => 'Save & New'));
        $form->add('save_and_duplicate', 'submit', array('label' => 'Save & Duplicate'));
        $form->add('delete', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'button danger', 'onclick' => 'return confirm("Are you sure you want to delete selected record?")')));

        return $form;
    }

    /**
     * Edits an existing AudioRecords entity.
     *
     * @param Request $request
     * @param type    $id
     *
     * @Route("/{id}", name="record_update")
     * @Method("PUT")
     * @Template("ApplicationFrontBundle:AudioRecords:edit.html.php")
     * @return array
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationFrontBundle:AudioRecords')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AudioRecords entity.');
        }
        $user = $this->getUser();
        $fieldsObj = new DefaultFields();
        $userViewSettings = $fieldsObj->getDefaultOrder();
        $data = $fieldsObj->getData(1, $em, $user, null, $entity->getRecord()->getId());
        //  $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $em, $data);
        $editForm->handleRequest($request);
        $result = $this->checkUniqueId($request, $entity->getRecord()->getId());
        if ($result != '') {
            $error = new FormError("The unique ID must be unique.");
            $editForm->get('record')->get('uniqueId')->addError($error);
        }
        if ($editForm->get('delete')->isClicked()) {
            return $this->redirect($this->generateUrl('record_delete', array('id' => $id)));
        }
        if ($editForm->isValid()) {
            try {
                $em->flush();
                $shpinxInfo = $this->getSphinxInfo();
                $sphinxSearch = new SphinxSearch($em, $shpinxInfo, $entity->getRecord()->getId(), 1);
                $sphinxSearch->replace();
                if (!in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles()) && $this->getUser()->getOrganizations() && ($editForm->get('save_and_duplicate')->isClicked() || $editForm->get('save_and_new')->isClicked()) && $this->container->getParameter("enable_stripe")) {
                    $paidOrg = $fieldsObj->paidOrganizations($this->getUser()->getOrganizations()->getId(), $em);
                    if ($paidOrg || is_array($paidOrg)) {
                        $org_records = $em->getRepository('ApplicationFrontBundle:Records')->countOrganizationRecords($this->getUser()->getOrganizations()->getId());
                        $counter = $org_records['total'];
                        $plan_limit = 2500;
                        $plan_id = "";
                        $creator = $this->getUser()->getOrganizations()->getUsersCreated();
                        if (in_array("ROLE_ADMIN", $creator->getRoles())) {
                            $plan_id = $creator->getStripePlanId();
                        }
                        if ($plan_id != NULL && $plan_id != "") {
                            $plan = $em->getRepository('ApplicationFrontBundle:Plans')->findBy(array("planId" => $plan_id));
                            $plan_limit = $plan[0]->getRecords();
                        }
                        if ($counter == $plan_limit) {
                            return $this->redirect($this->generateUrl('record_list_withdialog', array('dialog' => 1)));
                        }
                    }
                }
                // the save_and_dupplicate button was clicked
                if ($editForm->get('save_and_duplicate')->isClicked()) {
                    return $this->redirect($this->generateUrl('record_audio_duplicate', array('audioRecId' => $id)));
                }
                if ($editForm->get('save_and_new')->isClicked()) {
                    return $this->redirect($this->generateUrl('record_new', array('audioRecId' => $entity->getId())));
                }
                $this->get('session')->getFlashBag()->add('success', 'Audio record updated succesfully.');

                return $this->redirect($this->generateUrl('record_list'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                
            }
        }
        if ($entity->getRecord()->getProject()->getViewSetting()) {
            $defSettings = $fieldsObj->getDefaultOrder();
            $dbSettings = $entity->getRecord()->getProject()->getViewSetting();
            $userViewSettings = $fieldsObj->fields_cmp(json_decode($defSettings, true), json_decode($dbSettings, true));
//            $userViewSettings = $entity->getRecord()->getProject()->getViewSetting();
        }
        $userViewSettings = json_decode($userViewSettings, true);
        $tooltip = $fieldsObj->getToolTip(1);
        $allErrors = $this->allFormErrors($editForm);
        $images = $em->getRepository('ApplicationFrontBundle:RecordImages')->findBy(array('recordId' => $entity->getRecord()->getId()));

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            //   'delete_form' => $deleteForm->createView(),
            'fieldSettings' => $userViewSettings,
            'type' => $data['mediaType']->getName(),
            'allErrors' => $allErrors,
            'tooltip' => $tooltip,
            'images' => $images
        );
    }

    /**
     * Deletes a AudioRecords entity.
     *
     * @param integer $id
     * @param Request $request
     *
     * @route("/{id}", name = "record_delete")
     * @return redirect
     */
    public function delete($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ApplicationFrontBundle:AudioRecords')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AudioRecords entity.');
        }
        $shpinxInfo = $this->getSphinxInfo();
        $sphinxSearch = new SphinxSearch($em, $shpinxInfo, $entity->getRecord()->getId(), 1);
        $sphinxSearch->delete();
        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('record_list'));
    }

    /**
     * Creates a form to delete a AudioRecords entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('record_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'button danger', 'onclick' => 'return confirm("Are you sure?")')))
                        ->getForm();
    }

    /**
     * Displays a form to select media type abd projects.
     * @Route("/add-record", name="record_add")
     * @Method("GET")
     * @Template()
     * @return template
     */
    public function addRecordAction() {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('ApplicationFrontBundle:Projects')->findAll();
        $mediaTypes = $em->getRepository('ApplicationFrontBundle:MediaTypes')->findAll();

        return $this->render('ApplicationFrontBundle:AudioRecords:addRecord.html.twig', array(
                    'projects' => $projects,
                    'mediaTypes' => $mediaTypes
        ));
    }

    /**
     * Displays a base values in dropdown.
     *
     * @param integer $formatId Format id
     *
     * @Route("/getBase/{formatId}", name="record_get_base")
     * * @Route("/getBase/{selected}/{formatId}", name="record_getselected_base")
     * @Method("GET")
     * @Template()
     * @return template
     */
    public function getBaseAction($formatId, $selected = null) {
        $em = $this->getDoctrine()->getManager();
        $selectedBaseId = '';
        $bases = $em->getRepository('ApplicationFrontBundle:Bases')->findBy(array('baseFormat' => $formatId), array('order' => 'asc'));
        if ($selected) {
            $selectedBaseId = $selected;
        }
        return $this->render('ApplicationFrontBundle:AudioRecords:getBase.html.php', array(
                    'bases' => $bases,
                    'selectedBaseId' => $selectedBaseId,
        ));
    }

    /**
     * get recording speed values to show in dropdown.
     *
     * @param integer $formatId    Format id
     * @param integer $mediaTypeId
     *
     * @Route("/getRecordingSpeed/{formatId}/{mediaTypeId}", name="record_get_speed")
     * @Route("/getRecordingSpeed/{formatId}/{mediaTypeId}/{selectedrs}", name="record_get_speed")
     * @Method("GET")
     * @Template()
     * @return template
     */
    public function getRecordingSpeedAction($formatId, $mediaTypeId, $selectedrs = null) {
        $em = $this->getDoctrine()->getManager();
        if ($mediaTypeId == 3) {
            $speeds = $em->getRepository('ApplicationFrontBundle:RecordingSpeed')->findBy(array('recSpeedFormat' => NULL), array('order' => 'asc'));
        } else {
            $speeds = $em->getRepository('ApplicationFrontBundle:RecordingSpeed')->findBy(array('recSpeedFormat' => $formatId), array('order' => 'asc'));
        }

        return $this->render('ApplicationFrontBundle:AudioRecords:getRecordingSpeed.html.php', array(
                    'speeds' => $speeds,
                    'selectedrs' => $selectedrs
        ));
    }

    /**
     * get format values to show in dropdown.
     *
     * @param integer $mediaTypeId Media type id
     * @param integer $formatId
     *
     * @Route("/getFormat/{mediaTypeId}", name="record_get_format")
     * @Route("/getFormat/{mediaTypeId}/{formatId}", name="record_get_format_selected")
     * @Method("GET")
     * @Template()
     * @return template
     */
    public function getFormatAction($mediaTypeId, $formatId = null) {
        $em = $this->getDoctrine()->getManager();
        $formats = $em->getRepository('ApplicationFrontBundle:Formats')->findBy(array('mediaType' => $mediaTypeId), array('name' => 'asc'));

        return $this->render('ApplicationFrontBundle:AudioRecords:getFormat.html.php', array(
                    'formats' => $formats,
                    'formatId' => $formatId
        ));
    }

    /**
     * get values to show in dropdown.
     *
     * @param integer $formatId Format id
     *
     * @Route("/getFormatVersion/{formatId}", name="record_get_formatversion")
     * @Route("/getFormatVersion/{formatId}/{versionId}", name="record_get_formatversion_version")
     * @Method("GET")
     * @Template()
     * @return template
     */
    public function getFormatVersionAction($formatId, $versionId = null) {
        $em = $this->getDoctrine()->getManager();
        $formatVersions = $em->getRepository('ApplicationFrontBundle:FormatVersions')->findBy(array('formatVersionFormat' => $formatId), array('order' => 'asc'));

        return $this->render('ApplicationFrontBundle:AudioRecords:getFormatVersion.html.php', array(
                    'formatVersions' => $formatVersions,
                    'selectedVersion' => $versionId
        ));
    }

    /**
     * get reel diameters values to show in dropdown.
     *
     * @param integer $formatId    Format id
     * @param integer $mediaTypeId
     *
     * @Route("/getReelDiameter/{formatId}/{mediaTypeId}", name="record_get_reeldiameter")
     * @Route("/getReelDiameter/{formatId}/{mediaTypeId}/{selectedRD}", name="record_get_reeldiameter_selected")
     * @Method("GET")
     * @Template()
     * @return template
     */
    public function getReelDiameterAction($formatId, $mediaTypeId, $selectedRD = Null) {
        $em = $this->getDoctrine()->getManager();
        if ($mediaTypeId == 2) {
            $reeldiameters = $em->getRepository('ApplicationFrontBundle:ReelDiameters')->findBy(array('reelFormat' => NULL), array('order' => 'asc'));
        } else {
            $reeldiameters = $em->getRepository('ApplicationFrontBundle:ReelDiameters')->findBy(array('reelFormat' => $formatId), array('order' => 'asc'));
        }

        return $this->render('ApplicationFrontBundle:AudioRecords:getReelDiameter.html.php', array(
                    'reeldiameters' => $reeldiameters,
                    'selectedRD' => $selectedRD
        ));
    }

    /**
     * Get sphinx parameters
     *
     * @return array
     */
    protected function getSphinxInfo() {
        return $this->container->getParameter('sphinx_param');
    }

    /**
     * Get all project.
     *
     * @param int $selectedProjectId
     *
     * @Route("/getAllProjects/", name="record_projects")
     * @Route("/getAllProjects/{selectedProjectId}", name="record_user_projects")
     * @Method("GET")
     * @Template()
     * @return type
     */
    public function getAllProjectsAction($selectedProjectId = null) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $projects = array();
        if (!in_array("ROLE_SUPER_ADMIN", $user->getRoles()) && $user->getOrganizations()) {
            $projects = $em->getRepository('ApplicationFrontBundle:Projects')->findBy(array('organization' => $user->getOrganizations()->getId(), 'status' => 1));
        } else if (in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projects = $em->getRepository('ApplicationFrontBundle:Projects')->findBy(array('status' => 1));
        }

        return $this->render('ApplicationFrontBundle:AudioRecords:getProjects.html.php', array(
                    'projects' => $projects,
                    'selectedProjectId' => $selectedProjectId
        ));
    }

    /**
     * Check is unqiue ID is unqiue within an organization.
     * 
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function checkUniqueId(Request $request, $id = 0) {
        $em = $this->getDoctrine()->getManager();
        $record = $request->request->get('application_bundle_frontbundle_audiorecords');
        $unique = $record['record']['uniqueId'];
        $project_id = $record['record']['project'];

        if (empty($project_id) || $project_id == '') {
            return '';
        }
        $user = $em->getRepository('ApplicationFrontBundle:Records')->findOneBy(array('project' => $project_id));

        if (count($user) != 0) {
            $records = $em->getRepository('ApplicationFrontBundle:Records')->findOrganizationUniqueRecords($user->getProject()->getOrganization()->getId(), $unique, $id);
            if (count($records) == 0) {
                return '';
            } else {
                return 'unique id not unique';
            }
        }
        return '';
    }

    /**
     * new record
     *
     * @param Request $request
     * 
     * @Route("/new/", name="new_record")
     * @Template()
     */
    public function newRecordAction(Request $request) {
        $fieldsObj = new DefaultFields();
        $session = $this->getRequest()->getSession();
        if (($session->has('termsStatus') && $session->get('termsStatus') == 0) || ($session->has('limitExceed') && $session->get('limitExceed') == 0)) {
            return $this->redirect($this->generateUrl('dashboard'));
        }
        $em = $this->getDoctrine()->getManager();
        if (!in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles()) && $this->getUser()->getOrganizations() && $this->container->getParameter("enable_stripe")) {
            $paidOrg = $fieldsObj->paidOrganizations($this->getUser()->getOrganizations()->getId(), $em);
            if ($paidOrg || is_array($paidOrg)) {
                $org_records = $em->getRepository('ApplicationFrontBundle:Records')->countOrganizationRecords($this->getUser()->getOrganizations()->getId());
                $counter = $org_records['total'];
                $plan_limit = 2500;
                $plan_id = "";
                $creator = $this->getUser()->getOrganizations()->getUsersCreated();
                if (in_array("ROLE_ADMIN", $creator->getRoles())) {
                    $plan_id = $creator->getStripePlanId();
                }
                if ($plan_id != NULL && $plan_id != "") {
                    $plan = $em->getRepository('ApplicationFrontBundle:Plans')->findBy(array("planId" => $plan_id));
                    $plan_limit = $plan[0]->getRecords();
                }
                if ($counter >= $plan_limit) {
                    return $this->redirect($this->generateUrl('record_list_withdialog', array('dialog' => 1)));
                }
            }
        }

        return $this->render('ApplicationFrontBundle:AudioRecords:newRecord.html.php');
    }

    private function allFormErrors($form) {
        $return = array();
        $errors = $form->getErrorsAsString();
        $all = explode(":", $errors);
        $skip = false;
        foreach ($all as $key => $value) {
            if (strpos("ERROR", trim($value)) !== FALSE && strpos("ERROR", trim($value)) === 0) {
                $skip = true;
                $required = explode("\n", $all[$key + 1]);
                $return[] = $required[0];
            }
            if ($skip) {
                $skip = FALSE;
            }
        }
        return $return;
    }

}
