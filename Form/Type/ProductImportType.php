<?php
//http://symfony.com/doc/current/book/forms.html
namespace TNQSoft\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\File;

class ProductImportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'label' => 'Excel file',
                'attr'=>array('help'=>'Hỗ trợ file Excel (.xlsx). Dung lượng không quá 2M.'),
                'required' => true
            ))
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $collectionConstraint = new Collection(array(
            'file' => array(
                new NotBlank(array('message' => 'Cần nhập File')),
                new File(array(
                    'maxSize' => '2M',
                    'mimeTypes' => array(
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ),
                    'mimeTypesMessage' => 'Chỉ hỗ trợ nhập từ file Excel (.xlsx).',
                    'maxSizeMessage' => 'Dung lượng file nhập lên tối đa 2 Mega byte.',
                ))
            ),
        ));
        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmProductImport';
    }
}
