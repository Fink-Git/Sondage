<?php

namespace RennesJeux\SondageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuxType extends AbstractType
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
            'data_class' => 'RennesJeux\SondageBundle\Entity\Jeux',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'rennesjeux_sondagebundle_jeux';
    }
}