<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'label' => 'Nom'
        ])
        ->add('prenom', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'label' => 'Prénom'
        ])
        ->add('email', EmailType::class, [
            'attr' => ['class' => 'form-control'],
            'label' => 'Email'
        ])
        ->add('telephone', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'label' => 'Téléphone'
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => ['class' => 'btn-submit']
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
