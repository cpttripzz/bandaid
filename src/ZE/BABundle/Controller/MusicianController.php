<?php

namespace ZE\BABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ZE\BABundle\Entity\Document;
use ZE\BABundle\Entity\Musician;

use ZE\BABundle\Form\MusicianType;

/**
 * Musician controller.
 *
 * @Route("/musician")
 */
class MusicianController extends Controller
{

    /**
     * Lists all Musician entities.
     *
     * @Route("/", name="musician")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ZE\BABundle\Entity\Musician')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Musician entity.
     *
     * @Route("/", name="musician_create")
     * @Method("POST")
     * @Template("ZEBABundle:Musician:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Musician();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('musician_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Musician entity.
     *
     * @param Musician $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Musician $entity)
    {
        $editId = sprintf('%09d', mt_rand(0, 1999999999));

        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));

        $form = $this->createForm(new MusicianType(), $entity, array(
            'action' => $this->generateUrl('musician_create'),
            'method' => 'POST',
            'editId' => $editId,
            'isNew' => false,
            'existing_files' =>$existingFiles
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     *
     * @Route("/upload", name="musician_upload")
     * @Template()
     */
    public function uploadAction(Request $request)
    {
        try {
            $editId = $request->get('editId');
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ZE\BABundle\Entity\Musician')->find($id);
            $document = new Document();

            $document->setAssociation($entity);
            $em->persist($document);
            $em->flush();
        } catch (\Exception $e){
            print_r($e);
        }
        if (false === $this->get('security.context')->isGranted('view', $entity)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        if (!preg_match('/^\d+$/', $editId))
        {
            throw new Exception("Bad edit id");
        }
        try {
            $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
        } catch (\Exception $e) {
            
        }

    }
    /**
     * Displays a form to create a new Musician entity.
     *
     * @Route("/new", name="musician_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Musician();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Musician entity.
     *
     * @Route("/{id}", name="musician_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ZE\BABundle\Entity\Musician')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Musician entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Musician entity.
     *
     * @Route("/{id}/edit", name="musician_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ZE\BABundle\Entity\Musician')->find($id);

        if (false === $this->get('security.context')->isGranted('view', $entity)) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Musician entity.');
        }

        $editForm = $this->createEditForm($entity, $request);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Musician entity.
    *
    * @param Musician $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Musician $entity, Request $request)
    {

        $editId = $request->get('editId');
        if (!preg_match('/^\d+$/', $editId))
        {
            $editId = sprintf('%09d', mt_rand(0, 1999999999));
            if ($entity->getId())
            {
                $this->get('punk_ave.file_uploader')->syncFiles(
                    array('from_folder' => 'attachments/' . $entity->getId(),
                        'to_folder' => 'tmp/attachments/' . $editId,
                        'create_to_folder' => true));
            }
        }
        if (false === $this->get('security.context')->isGranted('edit', $entity)) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));

        $form = $this->createForm(new MusicianType(), $entity, array(
            'action' => $this->generateUrl('musician_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'editId' => $editId,
            'isNew' => false,
            'existing_files' =>$existingFiles
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Musician entity.
     *
     * @Route("/{id}", name="musician_update")
     * @Method("PUT")
     * @Template("ZEBABundle:Musician:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ZE\BABundle\Entity\Musician')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Musician entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $request);
        $editForm->handleRequest($request);
        $editId = $request->get('editId');
        if ($editForm->isValid()) {
            $em->flush();
            $fileUploader = $this->get('punk_ave.file_uploader');
            $fileUploader->syncFiles(
                array('from_folder' => '/tmp/attachments/' . $editId,
                    'to_folder' => '/attachments/' . $entity->getId(),
                    'remove_from_folder' => true,
                    'create_to_folder' => true));
            return $this->redirect($this->generateUrl('musician_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Musician entity.
     *
     * @Route("/{id}", name="musician_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ZE\BABundle\Entity\Musician')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Musician entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('musician'));
    }

    /**
     * Creates a form to delete a Musician entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('musician_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
