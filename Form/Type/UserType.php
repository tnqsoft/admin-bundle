<?php

namespace TNQSoft\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isNew = is_null($builder->getData()->getId());

        $builder
            ->add('username', TextType::class, array(
                'label' => 'Tài khoản',
                'attr' => array('placeholder' => 'Tài khoản'),
            ))
            ->add('newPassword', PasswordType::class, array(
                'label' => 'Mật khẩu',
                'attr' => array(
                    'placeholder' => 'Mật khẩu',
                    'help'=> ($isNew === false)?'Để trống nếu không muốn cập nhật Mật khẩu.':''
                ),
                'required' => $isNew,
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'attr' => array('placeholder' => 'Email'),
            ))
            ->add('group', null, array(
                'label' => 'Nhóm người dùng',
                'placeholder' => 'Chọn nhóm',
                'attr' => array('class' => 'chosen-select'),
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
            'data_class' => 'TNQSoft\AdminBundle\Entity\User',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmUser';
    }
}
