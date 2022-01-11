<?php
namespace App\Http\Form;

use App\Domain\Entity\Filterdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class FilterDateType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // ...
        ->add('date_start', DateTimeType::class, [
            'date_label' => 'Starts On',
            'required'=> true,
            
        ])

        ->add('date_end', DateTimeType::class, [
            'date_label' => 'Starts On',
            'required' => true,
            
        ])
    ;
}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => Filterdate::class,
    ]);
}
}