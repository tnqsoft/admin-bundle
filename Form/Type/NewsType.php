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

class NewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', null, array(
                'placeholder' => 'Chọn danh mục',
                'attr' => array('class' => 'chosen-select'),
                'required' => true,
            ))
            ->add('title', TextType::class, array(
                'label' => 'Tiêu đề'
            ))
            ->add('slug', TextType::class, array(
                'label' => 'Slug',
                'attr'=>array('help'=>'Sử dụng trên đường link'),
            ))
            ->add('summary', TextareaType::class, array(
                'label' => 'Tóm tắt'
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Nội dung',
                'attr' => array('class' => 'summernote')
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
            'data_class' => 'TNQSoft\AdminBundle\Entity\News',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmNews';
    }
}
