<?php

namespace TNQSoft\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use TNQSoft\AdminBundle\Form\Type\ProductType;

class SaleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'title',
                'attr' => array('placeholder' => 'Tiêu đề'),
                'required' => true,
            ))
            ->add('percentage', NumberType::class, array(
                'label' => 'Phần trăm',
                'attr'=>array('help'=>'Phần trăm giảm giá, ví dụ: 10 (10%)'),
                'required' => true,
            ))
            ->add('beginDate', DateTimeType::class, array(
                'label' => 'Ngày bắt đầu',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd H:mm:00',
                'attr' => array('class' => 'datetimepicker')
            ))
            ->add('endDate', DateTimeType::class, array(
                'label' => 'Ngày kết thúc',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd H:mm:00',
                'attr' => array('class' => 'datetimepicker')
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Chú thích',
                'attr' => array('class' => 'summernote'),
                'required' => false,
            ))
            ->add('productsId', HiddenType::class, array(
                //'mapped' => false
            ))
            // ->add('productAutocomplete', ChoiceType::class, array(
            //     'label' => 'Chọn Sản phẩm',
            //     'attr' => array(
            //         'placeholder' => 'Lựa chọn sản phẩm',
            //         'class' => 'product-autocomplete'
            //     ),
            //     //'choices'  => array(null),
            //     'required' => false,
            //     'mapped' => false
            // ))
            //->add('products', null, array())
            ->add('isActive', null, array(
                'label' => 'Trạng thái',
                'attr' => array('class' => 'checkbox-switch-active')
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
            'data_class' => 'TNQSoft\AdminBundle\Entity\Sale',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmSale';
    }
}
