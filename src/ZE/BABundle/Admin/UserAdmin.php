<?php
 namespace ZE\BABundle\Admin;

 use Sonata\UserBundle\Admin\Model\UserAdmin as SonataUserAdmin;
 use Sonata\AdminBundle\Form\FormMapper as FormMapper;
 class UserAdmin extends SonataUserAdmin
 {
     /**
      * {@inheritdoc}
      */
     protected function configureFormFields(FormMapper $formMapper)
     {
         parent::configureFormFields($formMapper);
         $formMapper
             ->with('Associations')
             ->add('bands','sonata_type_collection',   array(
                     'label' => 'Bands',
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
             ->add('musicians','sonata_type_collection',   array(
                     'label' => 'Musicians',
                     'by_reference' => false,
                     'cascade_validation' => true
                 ),
                 array(
                     'edit' => 'inline',
                     'inline' => 'table',
                     'allow_delete' => true,
                     'allow_add' => true,
                 )

             );


    }
 }