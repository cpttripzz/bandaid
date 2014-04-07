<?php

namespace ZE\BABundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use ZE\BABundle\Entity\City;

class DocumentAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('path');
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if($this->hasParentFieldDescription()) { // this Admin is embedded
            // $getter will be something like 'getlogoImage'
            $getter = 'get' . $this->getParentFieldDescription()->getFieldName();

            // get hold of the parent object
            $parent = $this->getParentFieldDescription()->getAdmin()->getSubject();
            if ($parent) {
                $images = $parent->$getter();
            } else {
                $images = null;
            }
        } else {
            $images = array($this->getSubject());
        }

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
//        if ($images && ($webPath = $images->getWebPath())) {
//            // get the container so the full path to the image can be set
//            $container = $this->getConfigurationPool()->getContainer();
//            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;
//
//            // add a 'help' option containing the preview's img tag
//            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
//        }

        if ($images) {
            $imgPath = '';
            foreach ($images as $image) {
                if ($image && ($webPath = $image->getWebPath())) {
                    $container = $this->getConfigurationPool()->getContainer();
                    $fullPath = $container->get('request')->getBasePath().'/'.$webPath;
                    // add a 'help' option containing the preview's img tag
                    $imgPath .= '<img src="' . $fullPath . '" class="admin-preview" />';
                }
            }
            $fileFieldOptions['help'] = $imgPath;
        }

        $formMapper
            // ... other fields ...
            ->add('file', 'file', $fileFieldOptions)
            ->add('name')
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
            ->add('name')
            ->add('path')
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
            ->add('name', null)
            ->add('path', null)
        ;
    }

    public function prePersist($image) {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image) {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image) {
        $x = $image;
    }
}