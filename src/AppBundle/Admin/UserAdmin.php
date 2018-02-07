<?php

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\ProfileType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            //->add('id')
            ->add('name', '', ['label' => '呢称'])
            ->add('profile.real_name', '', ['label' => '真实姓名'])
            ->add('profile.age', '', ['label' => '年龄'])
            ->add('profile.sex', 'boolean', ['label' => '性别', 'editable' => 'Yes'])
            ->add('book.name', '', ['label' => '书名'])
            ->add('_action', null, [
                'label' => '操作',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]

            ]);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('帐号信息', array('class' => 'col-md-9'))
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
            ))
            ->end();
        $formMapper
            ->with('个人资料', array('class' => 'col-md-9'))
            ->add('profile', ProfileType::class
            // ['empty_value' => false]
            )
            ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', '', ['label' => '呢称'])
            ->add('profile.real_name', '', ['label' => '真实姓名'])
            ->add('profile.age', '', ['label' => '年龄'])
            ->add('profile.sex', '', ['label' => '性别'])
            ->add('book.name', '', ['label' => '书名']);
    }

    public function toString($object)
    {
        return $object instanceof User
            ? $object->getName()
            : '用户管理'; // shown in the breadcrumb on the create view
    }

}
