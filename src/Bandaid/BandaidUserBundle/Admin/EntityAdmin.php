<?php
/**
 * Created by PhpStorm.
 * User: zach
 * Date: 12/7/13
 * Time: 8:33 PM
 */
namespace Bandaid\BandaidUserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class EntityAdmin extends Admin
{
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('user_id')
            ->add('entity_type')
            ->add('description');
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('enabled', null, array('required' => false))
            ->add('title')
            ->add('abstract')
            ->add('content')
            ->end()
            ->with('Tags')
            ->add('tags', 'sonata_type_model', array('expanded' => true))
            ->end()
            ->with('Comments')
            ->add('comments', 'sonata_type_model')
            ->end()
            ->with('System Information', array('collapsed' => true))
            ->add('created_at')
            ->end()
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('enabled')
            ->add('abstract')
            ->add('content')
            ->add('tags')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('enabled')
            ->add('tags', null, array('field_options' => array('expanded' => true, 'multiple' => true)))
        ;
    }

}