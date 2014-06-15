<?php

namespace ZE\BABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MusicianType extends AbstractType
{
    private $optionalVars = array('editId', 'existing_files', 'isNew');

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('instruments', 'genemu_jqueryselect2_entity', array(
                'multiple' => true,
                'class' => 'ZE\BABundle\Entity\Instrument',
                'property' => 'name',
            ))
            ->add('genres', 'genemu_jqueryselect2_entity', array(
                'multiple' => true,
                'class' => 'ZE\BABundle\Entity\Genre',
                'property' => 'name',
            ))

        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        foreach ($this->optionalVars as $optVar) {
            if (isset($options[$optVar])) {
                $view->$optVar = $options[$optVar];
            }
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ZE\BABundle\Entity\Musician'
        ));
        $resolver->setOptional($this->optionalVars);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ze_babundle_musician';
    }
}
