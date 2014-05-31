<?php

namespace ZE\BABundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use ZE\BABundle\Entity\City;
use ZE\BABundle\Entity\Musician;

class BandAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('addresses')
            ->add('genres');
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
            ->add('addresses','sonata_type_collection',   array(
                    'label' => 'addresses',
                    'by_reference' => false,
                    'cascade_validation' => true
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'allow_delete' => true,
                    'allow_add' => true,
                )
            )
            ->add('genres','sonata_type_collection',   array(
                    'label' => 'genres',
                    'by_reference' => false,
                    'cascade_validation' => true
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'allow_delete' => true,
                    'allow_add' => true,
                )
            )
            ->end();
//            if($this->getSubject() instanceof Musician){
//                $formMapper
//                    ->add('instruments','sonata_type_collection',   array(
//                            'label' => 'instruments',
//                            'by_reference' => false,
//                            'cascade_validation' => true
//                        ),
//                        array(
//                            'edit' => 'inline',
//                            'inline' => 'table',
//                            'allow_delete' => true,
//                            'allow_add' => true,
//                        )
//                    );
//            }

    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('genres')
            ->add('addresses')
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
            ->add('genres')
        ;
    }
}
