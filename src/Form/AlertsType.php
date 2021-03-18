<?php

namespace App\Form;

use App\Entity\Alerts;
use App\Entity\Programmes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AlertsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('programme',EntityType::class,['class'=>Programmes::class,'choice_label'=>'nom','multiple'=>false])
            ->add('localisation')
            ->add('date')
            ->add('rapport',TextareaType::class)
            ->add('telephone')
            ->add('mail')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Alerts::class,
        ]);
    }
}
