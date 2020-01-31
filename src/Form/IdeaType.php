<?php

namespace App\Form;

use App\Entity\Idea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdeaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label'=>'Super Wish :)', 'attr'=>['class'=>'color-pink']])
            ->add('description')
            ->add('author')
            ->add('dateDeadline', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('isPublished')
            ->add('Create', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Idea::class,
        ]);
    }
}
