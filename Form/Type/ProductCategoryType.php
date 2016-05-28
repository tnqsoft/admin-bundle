<?php

namespace TNQSoft\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Yavin\Symfony\Form\Type\TreeType;
use TNQSoft\AdminBundle\Entity\ProductCategory;

class ProductCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent', TreeType::class, array(
                'class' => ProductCategory::class,
                'levelPrefix' => '--',
                'orderFields' => array('root' => 'asc'),
                'prefixAttributeName' => 'data-level-prefix',
                'treeLevelField' => 'lvl',
                //'placeholder' => 'Chọn danh mục cha',
                'required' => false
            ))
            ->add('title', TextType::class, array(
                'label' => 'Tiêu đề'
            ))
            ->add('slug', TextType::class, array(
                'label' => 'Slug',
                'attr'=>array('help'=>'Sử dụng trên đường link'),
            ))
            ->add('file', FileType::class, array(
                'image_path' => 'webPath',
                'label' => 'Ảnh',
                'required' => false
            ))
            ->add('isActive', null, array(
                'label' => 'Trạng thái',
                'attr' => array('class' => 'checkbox-switch-active')
            ))
            ->add('metaKeywords', TextareaType::class, array(
                'label' => 'Meta Keywords',
                'required' => false
            ))
            ->add('metaDescription', TextareaType::class, array(
                'label' => 'Meta Description',
                'required' => false
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Ghi nhớ',
                'attr' => array(
                    'iconLeft' => 'fa fa-save'
                )
            ))
            ->add('saveAndAdd', SubmitType::class, array(
                'label' => 'Ghi nhớ và Thêm',
                'attr' => array(
                    'iconLeft' => 'fa fa-save'
                )
            ))
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TNQSoft\AdminBundle\Entity\ProductCategory',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmProductCategory';
    }
}
