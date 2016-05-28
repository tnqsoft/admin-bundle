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

class BannerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'image_path' => 'webPath',
                'label' => 'Ảnh',
                'attr' => array('help' => 'Kích thước chuẩn 1200x550 pixel'),
                'required' => false
            ))
            ->add('url', TextType::class, array(
                'label' => 'url',
                'attr' => array('placeholder' => 'Liên kết'),
                'required' => false,
            ))
            ->add('target', ChoiceType::class, array(
                'label' => 'Mở liên kết',
                'choices'  => array(
                    'Cùng một cửa sổ' => '_self',
                    'Cửa sổ mới' => '_blank',
                    'Trong khung gốc' => '_parent',
                    'Đầy đủ' => '_top',
                ),
                'required' => false,
            ))
            ->add('position', ChoiceType::class, array(
                'label' => 'Vị trí',
                'attr'=>array('help'=>'Vị trí hiển thị banner'),
                'choices'  => array(
                    'Banner Top' => 'banner-top',
                ),
                'required' => true,
            ))
            ->add('ordering', NumberType::class, array(
                'label' => 'Thứ tự',
                'attr'=>array('help'=>'Thứ tự hiển thị'),
                'required' => true,
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
            'data_class' => 'TNQSoft\AdminBundle\Entity\Banner',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmBanner';
    }
}
