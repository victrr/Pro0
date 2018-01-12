<?php

namespace Vct\ModBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apPaterno')
            ->add('apMaterno')
            ->add('save','submit', array('label' => 'save people'));

    }/**
     * * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vct\ModBundle\Entity\Persona'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'persona';
    }


}
