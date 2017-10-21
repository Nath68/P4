<?php

namespace ML\billetterieBundle\Form;

use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //->add('dateCmd')
        $builder->add('dateVisite', DateType::class, array('label' => 'Date de visite',
            'widget' => 'single_text', 'format' => 'dd-MM-yyyy',

            // do not render as type="date", to avoid HTML5 date pickers
            'html5' => false,

            // add a class that can be selected in JavaScript
            'attr' => ['class' => 'calendar'],

            //'attr' => array('readonly' => true)
        ))
            //->add('tarif')
        ->add('mail', EmailType::class, array('label' => 'Email'))
        //->add('code')
        //->add('nbrBillets');

            

        ->add('duree', CheckboxType::class, array('required' => false, 'label' => 'Demi-journée'))
        ->add('billets', CollectionType::class, array('entry_type' => BilletsType::class,
            'allow_add' => true, 'allow_delete' => true, 'by_reference' => false))
        ->add('Commander', SubmitType::class);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ML\billetterieBundle\Entity\Commandes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ml_billetteriebundle_commandes';
    }


}
