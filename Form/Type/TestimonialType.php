<?php

namespace TNQSoft\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TestimonialType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'label' => 'Họ'
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Tên'
            ))
            ->add('jobtitle', TextType::class, array(
                'label' => 'Nghề nghiệp'
            ))
            ->add('company', TextType::class, array(
                'label' => 'Công ty',
                'required' => false
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Lời nhắn',
            ))
            ->add('file', FileType::class, array(
                'image_path' => 'webPath',
                'label' => 'Ảnh đại diện',
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
            'data_class' => 'TNQSoft\AdminBundle\Entity\Testimonial',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmTestimonial';
    }
}
