<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('pic', FileType::class, [
                'label' => 'Picture',


                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',

                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg document',
                    ])
                ],
            ])
             ->add('currentPassword', PasswordType::class, [
                  // instead of being set onto the object directly,
                  // this is read and encoded in the controller
                  'mapped' => false,
                  'attr' => ['class' => 'password-field'],
                  'required' => false,
              ])
              ->add('Password', RepeatedType::class, [
                  // instead of being set onto the object directly,
                  // this is read and encoded in the controller
                  'type' => PasswordType::class,
                  'mapped' => false,
                  'options' => ['attr' => ['class' => 'password-field']],
                  'required' => false,
                  'first_options' => ['label' => 'New Password'],
                  'second_options' => ['label' => 'Confirm Password'],
                  'constraints' => [
                      new Length([
                          'min' => 6,
                          'minMessage' => 'Your password should be at least {{ limit }} characters',
                          // max length allowed by Symfony for security reasons
                          'max' => 4096,
                      ]),
                  ],
              ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
