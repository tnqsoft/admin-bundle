<?php

namespace TNQSoft\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use TNQSoft\AdminBundle\Form\Type\PhotoType;

class PhotoCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Tiêu đề'
            ))
            ->add('slug', TextType::class, array(
                'label' => 'Slug',
                'attr'=>array('help'=>'Sử dụng trên đường link'),
            ))
            ->add('summary', TextareaType::class, array(
                'label' => 'Tóm tắt',
                'attr' => array('class' => 'summernote'),
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
            ->add('listPhoto', CollectionType::class, array(
                'entry_type'   => PhotoType::class,
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
            'data_class' => 'TNQSoft\AdminBundle\Entity\PhotoCategory',
            'cascade_validation' => true,
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmPhotoCategory';
    }
}
