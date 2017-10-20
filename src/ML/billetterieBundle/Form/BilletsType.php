<?php

namespace ML\billetterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom'))
            ->add('prenom', TextType::class, array('label' => 'Prénom'))
            ->add('pays', TextType::class, array('label' => 'Pays'))
            ->add('dateNaissance', BirthdayType::class, array('label' => 'Date de naissance', 'format' => 'dd-MM-yyyy'/*, 'attr' => array('years' => 100)*/))
            ->add('tarifReduit', CheckboxType::class, array('required' => false, 'label' => 'Tarif réduit (étudiant, employé du musée, ministère de la culture, militaire...)'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ML\billetterieBundle\Entity\Billets'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ml_billetteriebundle_billets';
    }


}
