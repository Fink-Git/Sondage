<?php

namespace RennesJeux\SondageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use RennesJeux\SondageBundle\Entity\Jeux;
use RennesJeux\SondageBundle\Entity\Session;

class JeuxType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	      ->add('nom',       		TextType::class)
	      ->add('hote',      		TextType::class, array('disabled' => true))
	      ->add('lieu',      		TextType::class)
	      ->add('nbparticipantmin', IntegerType::class)
	      ->add('nbparticipantmax', IntegerType::class)
	      ->add('sessions', CollectionType::class, array(
	      	'entry_type' => SessionType::class,
	      	'allow_add'  => true,
	      	'allow_delete' => true,
	      	'by_reference' => false))
	      ->add('save',      		SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Jeux::class,
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