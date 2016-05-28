<?php

namespace TNQSoft\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Yavin\Symfony\Form\Type\TreeType;
use TNQSoft\AdminBundle\Entity\Menu;

class MenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent', TreeType::class, array(
                'class' => Menu::class,
                'levelPrefix' => '--',
                'orderFields' => array('lft' => 'asc'),
                'prefixAttributeName' => 'data-level-prefix',
                'treeLevelField' => 'lvl',
                //'placeholder' => 'Chọn danh mục cha',
                'required' => false,
            ))
            ->add('title', TextType::class, array(
                'label' => 'Tiêu đề'
            ))
            ->add('routerName', ChoiceType::class, array(
                'label' => 'Liên kết',
                'attr'=>array('help'=>'Tên của routing trong hệ thống'),
                'choices'  => array(
                    'Phân cách' => 'separator',
                    'Trang chủ' => 'homepage',
                    'Liên hệ' => 'frontend_contact',
                    'Bản đồ' => 'frontend_map',
                    'Trang tĩnh' => 'frontend_page_detail',
                    'Tin tức' => array(
                        'Danh mục tin' => 'frontend_news_category',
                        'Tin chi tiết' => 'frontend_news_detail',
                    ),
                    'Dự án' => array(
                        'Danh sách dự án' => 'frontend_photo_categories',
                        'Dự án chi tiết' => 'frontend_photo_category_detail',
                    ),
                    'Sản phẩm' => array(
                        'Tất cả danh mục sản phẩm' => 'frontend_product_category',
                        'Danh mục sản phẩm cấp 1' => 'frontend_product_list_level1',
                        'Danh mục sản phẩm cấp 2' => 'frontend_product_list_level2',
                        'Sản phẩm chi tiết' => 'frontend_product_detail',
                    ),
                    'Ý kiến khách hàng' => 'frontend_testimonial_list',
                ),
                'required' => false,
            ))
			->add('parameters', TextType::class, array(
                'label' => 'Tham số',
                'attr'=>array('help'=>'Tham số truyền vào routing'),
				'required' => false,
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
            'data_class' => 'TNQSoft\AdminBundle\Entity\Menu',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmMenu';
    }
}
