<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => '图文资讯标题',
                'attr' => array(
                    'placeholder' => '请输入图文资讯标题'
                ),
            ))
            ->add('book', EntityType::class, array(
                'label' => '图文资讯标签',
                'class' => 'AppBundle:Book',
                'choice_label' => 'name',
                //'multiple'=>TRUE,
                'expanded' => FALSE,
                'attr' => array(
                    'help' => '请选择图文资讯标签，标签可以用作图文资讯的分类，一篇图文资讯可以有多个标签',
                ),
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ));
        $builder->add('profile', ProfileType::class
           // ['empty_value' => false]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
