<?php

namespace App\Form;

use App\Entity\Terrain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numTel',TextType::class, [
                   'label' => 'numTel',
                   'attr' => [
                   'placeholder' => '+216 23 456 789',
                 ],

            ])
            ->add('localisation',TextType::class, [
                'label' => 'localisation',
                'attr' => [
                    'placeholder' => 'localisation'
                ],
                ])
            ->add('description' ,TextType::class, [
                  'label' => 'description',
                  'attr' => [
                       'placeholder' => 'description'
                  ],
            ])
            ->add('status',TextType::class, [
                'label' => 'status',
                'attr' => [
                    'placeholder' => 'status'
                ],
            ])
            ->add('prix',TextType::class, [
                'label' => 'prix',
                'attr' => [
                    'placeholder' => 'prix'
                ],
            ])
            ->add('type')
            ->add('imageFile', FileType::class,[
                'required'=>false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
