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
            ->add('begin_date', DateTimeType::class, array(
                'label' => 'Ngày bắt đầu',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd H:s',
                'attr' => array('class' => 'datetimepicker')
            ))
            ->add('end_date', DateTimeType::class, array(
                'label' => 'Ngày kết thúc',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd H:s',
                'attr' => array('class' => 'datetimepicker')
            ))
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
