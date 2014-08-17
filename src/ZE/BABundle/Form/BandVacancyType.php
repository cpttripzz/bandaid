<?php
namespace ZE\BABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BandVacancyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('genres', 'genemu_jqueryselect2_entity', array(
            'multiple' => true,
            'class' => 'ZE\BABundle\Entity\Genre',
            'property' => 'name',
            'show_legend' => false,
            'show_child_legend' => false,
        ))
            ->add('instruments', 'genemu_jqueryselect2_entity', array(
                'multiple' => true,
                'class' => 'ZE\BABundle\Entity\Instrument',
                'property' => 'name', 'show_legend' => false,
                'show_child_legend' => false,
            ))
            ->add('comment')
            ->add('name');

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ZE\BABundle\Entity\BandVacancy',
        ));
    }

    public function getName()
    {
        return 'band_vacancy';
    }
}