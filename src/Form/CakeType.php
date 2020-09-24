<?php
namespace App\Form;

use App\Entity\Cake;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CakeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255])
            ],
        ])
        ->add('description', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255])
            ],
        ])
        ->add('price', NumberType::class, [
            'scale' => 2, // 2 digits float
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\GreaterThan(0),
            ],
        ])
        ->add('image', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255]),
                new Assert\Url(),
            ],
        ])
;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            // this form type would be able to populate our domain object :)
            'data_class' => Cake::class,
        ));
    }

}