<?php

namespace TNQSoft\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Yavin\Symfony\Form\Type\TreeType;
use TNQSoft\AdminBundle\Entity\ProductCategory;
use TNQSoft\AdminBundle\Form\Type\ProductImgType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', TreeType::class, array(
                'class' => ProductCategory::class,
                'levelPrefix' => '--',
                'orderFields' => array('root' => 'asc'),
                'prefixAttributeName' => 'data-level-prefix',
                'treeLevelField' => 'lvl',
                'placeholder' => 'Chọn danh mục',
                'required' => true
            ))
            ->add('partner', null, array(
                'placeholder' => 'Chọn đối tác',
                'required' => true
            ))
            ->add('upc', TextType::class, array(
                'label' => 'Mã sản phẩm',
                'attr'=>array('help'=>'Mã sản phẩm là duy nhất, không được trùng'),
            ))
            ->add('title', TextType::class, array(
                'label' => 'Tên sản phẩm'
            ))
            ->add('summary', TextareaType::class, array(
                'label' => 'Tóm tắt'
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Chi tiết',
                'attr' => array('class' => 'summernote')
            ))
            ->add('price', NumberType::class, array(
                'label' => 'Giá sản phẩm'
            ))
            ->add('outOfStock', null, array(
                'label' => 'Còn hàng',
                'attr' => array('class' => 'checkbox-switch-active')
            ))
            ->add('isActive', null, array(
                'label' => 'Trạng thái',
                'attr' => array('class' => 'checkbox-switch-active')
            ))
            ->add('isNew', null, array(
                'label' => 'Hàng mới',
                'attr' => array('class' => 'checkbox-switch-active')
            ))
            ->add('isSpecial', null, array(
                'label' => 'Hàng đặc biệt',
                'attr' => array('class' => 'checkbox-switch-active')
            ))
            ->add('listPhoto', CollectionType::class, array(
                'entry_type'   => ProductImgType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
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
            'data_class' => 'TNQSoft\AdminBundle\Entity\Product',
            'cascade_validation' => true,
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmProduct';
    }
}
