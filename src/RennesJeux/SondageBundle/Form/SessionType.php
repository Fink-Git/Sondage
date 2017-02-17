<?php

namespace RennesJeux\SondageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use RennesJeux\SondageBundle\Entity\Session;

class SessionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $year = date("Y");
         $builder
      		->add('date', DateType::class, array(
                    'years' => range($year,$year + 1)
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Session::class,
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