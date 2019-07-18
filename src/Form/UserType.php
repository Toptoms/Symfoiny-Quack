<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
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
