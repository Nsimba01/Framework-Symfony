<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Atelier;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AtelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
           'required' => true,
           'label' => "Nom de  l'atelier",
		    'constraints' => [
              new NotBlank([
                 'message' => 'Veuillez saisir un nom'
              ]),
              new Length([
                 'min' => 6,
                 'minMessage' => 'Le nom doit contenir au minimum {{ limit }} caractères'
              ]),
           ]
        ])
			->add('Description', TextareaType::class, [
           'required' => true,
           'label' => "Description de l'atelier",
		   'constraints' => [
              new NotBlank([
                 'message' => 'Veuillez saisir une Description'
              ])
           ]
        ])
			->add('save', SubmitType::class, [
           'label' => 'Valider'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
			'data_class' => Atelier :: class, 
        ]);
    }
}
