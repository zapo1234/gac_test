<?php
namespace App\Http\Form;

use App\Domain\Entity\Filedata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UploadfileType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // ...
        ->add('filename', FileType::class, [
            'label' => 'Envoi d\'un fichier csv',
            'mapped' => false,
            'required' => true,
        ]

      );
    ;
}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => Filedata::class,
    ]);
}
}

















