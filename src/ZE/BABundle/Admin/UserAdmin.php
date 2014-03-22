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
             ->with('new_section')
             ->add(...)
                // ...
            ->end()
     ;
    }
 }