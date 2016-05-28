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

class ProductImgType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Tiêu đề',
                'attr' => array('placeholder' => 'Tiêu đề ảnh')
            ))
            ->add('file', FileType::class, array(
                'image_path' => 'webPath',
                'label' => 'Ảnh',
                'required' => false
            ))
            ->add('isDefault', null, array(
                'label' => 'Đại diện',
                'attr' => array('class' => 'checkbox-switch-photo-default')
            ))
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TNQSoft\AdminBundle\Entity\ProductImg',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmProductImg';
    }
}
