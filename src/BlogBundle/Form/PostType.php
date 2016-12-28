<?php

namespace BlogBundle\Form;

use BlogBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PostType
 * @package BlogBundle\Form
 */
class PostType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width:100%',
                ]
            ])
            ->add('teaser', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 100%; height: 200px',
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 100%; height: 500px',
                ]
            ])
            ->add('Сохранить', SubmitType::class, [
                'attr' => [
                    'value' => 'Сохранить',
                    'class' => 'btn btn-primary',
                    'style' => 'margin-top:20px;',
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}