<?php

namespace ZE\BABundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use ZE\BABundle\Entity\Musician;

class MusicianAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('addresses','sonata_type_collection', array(
                'allow_add' => true,
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'
            ))

            ->add('documents','sonata_type_collection', array(), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'
            ))
            ->add('genres','sonata_type_collection', array(
                'allow_add' => true,
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'
            ))
        ;
        
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('addresses','sonata_type_collection', array(),array(
                'allow_add' => true,
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'
            ))

            ->add('documents','sonata_type_collection', array(), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'
            ))
            ->add('genres','sonata_type_collection', array(),array(
                'allow_add' => true,
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'
            ));

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
            ->add('addresses')
            ->add('documents')
            ->add('genres')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
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
            ->add('addresses')
            ->add('documents')
            ->add('genres')
        ;
    }
}