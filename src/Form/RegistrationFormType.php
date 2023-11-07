<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nazwa użytkownika',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'attr' => [
                    'class' => 'w-full rounded-md border border-blue-500 outline focus:outline focus:border-red-400 px-3 py-2 my-2'
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Imię',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'attr' => [
                    'class' => 'w-full rounded-md border border-blue-500 focus:outline focus:border-blue-700 px-3 py-2 my-2'
                ]
            ])
            ->add('middleName', TextType::class, [
                'label' => 'Drugie imię (opcjonalne)',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'required' => false,
                'attr' => [
                    'class' => 'w-full rounded-md border border-blue-500 focus:outline focus:border-blue-700 px-3 py-2 my-2'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nazwisko',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'attr' => [
                    'class' => 'w-full rounded-md border border-blue-500 focus:outline focus:border-blue-700 px-3 py-2 my-2'
                ]
            ])
            ->add('mobile', TextType::class, [
                'label' => 'Numer telefonu',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'attr' => [
                    'class' => 'w-full rounded-md border border-blue-500 focus:outline focus:border-blue-700 px-3 py-2 my-2'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Adres e-mail',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'attr' => [
                    'class' => 'w-full rounded-md border border-blue-500 focus:outline focus:border-blue-700 px-3 py-2 my-2'
                ]
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Opis (opcjonalne)',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'attr' => [
                    'class' => 'w-full rounded-md border border-blue-500 focus:outline focus:border-blue-700 px-3 py-2 my-2'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Hasło',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'w-full rounded-md border border-blue-500 focus:outline focus:border-blue-700 px-3 py-2 my-2'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Podaj hasło',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Twoje hasło musi mieć minimum {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Zgoda na Warunki Użytkowania',
                'label_attr' => [
                    'class' => 'block font-bold text-sm text-gray-800 py-2', // Apply Tailwind CSS classes here
                ],
                'mapped' => false,
                'attr' => [
                    'class' => ' rounded-md border border-blue-500 focus:outline focus:border-blue-700 my-2'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Aby zarejestrować się w twarzoksiążce, musisz zapoznać się z naszymi Warunkami Użytkownikania i je zaakceptować.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
