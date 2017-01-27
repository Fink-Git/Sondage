<?php

namespace RennesJeux\SondageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RennesJeux\SondageBundle\Entity\Session',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'rennesjeux_sondagebundle_session';
    }
}