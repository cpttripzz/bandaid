<?php

namespace ZE\BABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ZE\BABundle\Entity\Band;
use ZE\BABundle\Form\BandType;

/**
 * Band controller.
 *
 * @Route("/band")
 */
class BandController extends Controller implements UrlTracker
{


    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT b FROM ZEBABundle:Band b";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),16
        );
        $pagination->setTemplate('KnpPaginatorBundle:Pagination:twitter_bootstrap_v3_pagination.html.twig');
        return $this->render('ZEBABundle:Band:index.html.twig' , array('pagination' => $pagination, 'entity_type' => 'band'));
    }

    public function createAction(Request $request)
    {
        $entity = new Band();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('band_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Band entity.
     *
     * @param Band $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Band $entity)
    {
        $form = $this->createForm(new BandType(), $entity, array(
            'action' => $this->generateUrl('band_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    public function newAction()
    {
        $entity = new Band();
        $form   = $this->createCreateForm($entity);

        return $this->render('ZEBABundle:Band:new.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    public function showAction(Band $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Band entity.');
        }

        return $this->render('ZEBABundle:Band:show.html.twig', array(
            'entity'      => $entity,
        ));

        return array(
            'entity'      => $entity
        );
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ZEBABundle:Band')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Band entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ZEBABundle:Band:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Band entity.
    *
    * @param Band $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Band $entity)
    {
     if (false === $this->get('security.context')->isGranted('edit', $entity)) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        $form = $this->createForm(new BandType(), $entity, array(
            'action' => $this->generateUrl('band_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ZEBABundle:Band')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Band entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('band_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ZEBABundle:Band')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Band entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('band'));
    }

    /**
     * Creates a form to delete a Band entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('band_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
