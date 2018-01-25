<?php

namespace Vct\ModBundle\Form;

use Vct\ModBundle\Entity\Persona;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vct\ModBundle\Form\PersonaType;

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
        
        $builder->add('tel', 'collection', array('type' => new \Vct\ModBundle\Form\TelefonoType(), 'allow_add' => true,'prototype' => true,));
        


    }

    /**
    * @param OptionsResolverInterface $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vct\ModBundle\Entity\Persona',
        ));
    }

    


}
