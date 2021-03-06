<?php

namespace ZE\BABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BandVacancyAssociationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bandVacancy', new BandVacancyType(),array(
                'show_legend' => false,
                'show_child_legend' => false,
                'label_render' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ZE\BABundle\Entity\BandVacancyAssociation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ze_babundle_bandvacancyassociation';
    }
}
