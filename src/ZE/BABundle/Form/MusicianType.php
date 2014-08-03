<?php

namespace ZE\BABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MusicianType extends AbstractType
{
    private $optionalVars = array('editId', 'existing_files', 'isNew');

    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->securityContext->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
                'no authenticated user!'
            );
        }
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
            ));
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event)  use ($user){
                $form = $event->getForm();
                $event->getData();
                $formOptions = array(

                    'class' => 'ZE\BABundle\Entity\Address',
                    'property' => 'longName',
                    'multiple' => true,
                    'required' =>false,
                    'query_builder' => function (EntityRepository $er) use ($user) {
                        // build a custom query

                        /*select * from address ad
                        inner join association a on a.id = ad.association_id
                        inner join fos_user_user u on u.id = a.user_id*/
//                        and user_id = 10
                        $qb = $er->createQueryBuilder('ad');
                        $qb->select('ad')
                            ->innerJoin('ad.associations', 'a')
                            ->innerJoin('a.user', 'u')
                            ->where('u.id = :userId');


                        $qb->setParameters(array(
                            'userId' => $user->getId()
                        ));
                        return $qb;

                    },
                );

                // create the field, this is similar the $builder->add()
                // field name, field type, data, options
                $form->add('addresses', 'genemu_jqueryselect2_entity', $formOptions);

//                $form->add('addresses', 'entity', $formOptions);
            }
        );
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
