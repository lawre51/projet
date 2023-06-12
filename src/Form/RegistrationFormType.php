<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\AtLeastOneOf;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            
            ->add('nom' ,TextType::class,[
                'required' => true,
                'constraints' => [new NotBlank(['message' => 'Entrez votre nom',]),
                new Length(['min' => 2,'minMessage' => 'Votre nom doit avoir plus de 2 caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096, ]),
                ]
            ,])


            ->add('prenom' ,TextType::class,[
                'required' => true,
                'constraints' => [new NotBlank(['message' => 'Entrez votre prenom',]),
                new Length(['min' => 2,'minMessage' => 'Votre nom doit avoir plus de 2 caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096, ]),
                ]
            ,])

            ->add('email',EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Email([
                        'message' => 'Votre Email n\'est pas valide.',
                    ]),
                ],    
            ],)
            

            ->add('plainPassword', PasswordType::class, [
                'required' => true,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit avoir au moins 6 caractères alphanumériques et caractères spécials',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            /*
            ->add('role' ,ChoiceType::class,[
                'constraints' => [new NotBlank(['message' => 'Entrez votre role',]),

                ]
            ,])
            */

            ->add('equipe' ,IntegerType::class,[
                'required' => true,
                'constraints' => [new NotBlank(['message' => 'Entrez votre équipe',]),
                new Range(['min' => 0,
                    'max' => 5, 'notInRangeMessage' => 'Saisie incorrecte', ]),
                ]
            ,])


            ->add('poste' ,TextType::class,[
                'required' => true,
                'constraints' => [new NotBlank(['message' => 'Entrez votre poste',]), 
                 ]

            ,])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
