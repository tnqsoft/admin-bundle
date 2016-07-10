<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use \PHPExcel_Cell_DataValidation;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TNQSoft\AdminBundle\Form\Type\ProductCategoryType;
use TNQSoft\AdminBundle\Entity\ProductCategory;
use TNQSoft\AdminBundle\Form\Type\ProductType;
use TNQSoft\AdminBundle\Form\Type\ProductImportType;
use TNQSoft\AdminBundle\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use TNQSoft\CommonBundle\Service\FileUploader;

/**
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * @Route("/", name="admin_product_list")
     */
    public function indexAction(Request $request)
    {
        $productRepository = $this->get('tnqsoft_admin.repository.product');
        $paginator = $productRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        if ($request->isMethod('POST')) {
            if($request->request->get('action', '') === 'update-price') {
                $listUpdate = $request->request->get('prices', array());
                if(!empty($listUpdate)) {
                    foreach($listUpdate as $id => $newPrice) {
                        $product = $productRepository->findOneById($id);
                        if (null !== $product) {
                            $product->setPrice($newPrice);
                            $productRepository->persist($product);
                        }
                    }
                    $productRepository->flush();
                }
            }
            $request->getSession()->getFlashBag()->add('success', 'Cập nhật giá thành công');
            return $this->redirect($this->generateUrl('admin_product_list', $request->query->all()));
        }

        return $this->render('TNQSoftAdminBundle:Product:index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/export/all.xls", name="admin_export_all_product")
     */
    public function exportExcelAction(Request $request)
    {
        $productRepository = $this->get('tnqsoft_admin.repository.product');
        $list = $productRepository->getAllProduct();

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        $phpExcelObject->getProperties()->setCreator("Symfony 3 CMS")
            ->setLastModifiedBy("Generate Automation")
            ->setTitle("All Products")
            ->setSubject("List of all products")
            ->setDescription("Document export from Symfony 3 CMS. Export at ".date('Y-m-d H:i:s'))
            ->setKeywords("Excel, Product")
            ->setCategory("product");
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Mã SP')
            ->setCellValue('C1', 'Tên SP')
            ->setCellValue('D1', 'Trạng thái kho')
            ->setCellValue('E1', 'Hàng mới')
            ->setCellValue('F1', 'Hàng đặc biệt')
            ->setCellValue('G1', 'Hoạt động')
            ->setCellValue('H1', 'Giá SP');
        $phpExcelObject->getActiveSheet()->setTitle('Products');

        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setWidth(15);

        $row = 1;
        foreach($list as $product) {
            $row++;
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'.$row, $product->getId())
                ->setCellValue('B'.$row, $product->getUpc())
                ->setCellValue('C'.$row, $product->getTitle())
                ->setCellValue('D'.$row, $product->getOutOfStock())
                ->setCellValue('E'.$row, $product->getIsNew())
                ->setCellValue('F'.$row, $product->getIsSpecial())
                ->setCellValue('G'.$row, $product->getIsActive())
                ->setCellValue('H'.$row, $product->getPrice());
            //Init Cell Data Validation
            $objValidation = $phpExcelObject->getActiveSheet()->getCell('D'.$row)->getDataValidation();
            $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"TRUE, FALSE"');
            //Init Cell Data Validation
            $objValidation = $phpExcelObject->getActiveSheet()->getCell('E'.$row)->getDataValidation();
            $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"TRUE, FALSE"');
            //Init Cell Data Validation
            $objValidation = $phpExcelObject->getActiveSheet()->getCell('F'.$row)->getDataValidation();
            $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"TRUE, FALSE"');
            //Init Cell Data Validation
            $objValidation = $phpExcelObject->getActiveSheet()->getCell('G'.$row)->getDataValidation();
            $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"TRUE, FALSE"');
        }

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'product-'.date('YmdHis').'.xlsx'
        );
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    /**
     * @Route("/import", name="admin_product_import_excel")
     * @Method({"GET", "POST"})
     */
    public function importExcelAction(Request $request)
    {
        $productRepository = $this->get('tnqsoft_admin.repository.product');
        $form = $this->createForm(ProductImportType::class);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $uploadDir = realpath($this->get('kernel')->getRootDir() . '/../var').DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR;
                $uploader = new FileUploader($uploadDir);
                $fileName = $uploader->upload($data['file']);

                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($uploadDir.$fileName);
                $objWorksheet = $phpExcelObject->getActiveSheet();
                $highestRow = $objWorksheet->getHighestRow();
                $countProcess = 0;
                for ($row = 2; $row <= $highestRow; ++$row) {
                    $id = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $newUPC = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $newTitle = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $newOutOfStock = filter_var($objWorksheet->getCellByColumnAndRow(3, $row)->getValue(), FILTER_VALIDATE_BOOLEAN);
                    $newIsNew = filter_var($objWorksheet->getCellByColumnAndRow(4, $row)->getValue(), FILTER_VALIDATE_BOOLEAN);
                    $newIsSpecial = filter_var($objWorksheet->getCellByColumnAndRow(5, $row)->getValue(), FILTER_VALIDATE_BOOLEAN);
                    $newIsActive = filter_var($objWorksheet->getCellByColumnAndRow(6, $row)->getValue(), FILTER_VALIDATE_BOOLEAN);
                    $newPrice = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();

                    $product = $productRepository->findOneById($id);
                    if (null !== $product) {
                        $product->setUpc($newUPC);
                        $product->setTitle($newTitle);
                        $product->setOutOfStock($newOutOfStock);
                        $product->setIsNew($newIsNew);
                        $product->setIsSpecial($newIsSpecial);
                        $product->setIsActive($newIsActive);
                        $product->setPrice($newPrice);
                        $productRepository->persist($product);
                        $countProcess++;
                    }
                }
                if($countProcess > 0) {
                    $productRepository->flush();
                }

                $request->getSession()->getFlashBag()->add('success', 'Cập nhật thành công '.$countProcess.' sản phẩm');
                return $this->redirect($this->generateUrl('admin_product_import_excel'));
            }
        }

        return $this->render('TNQSoftAdminBundle:Product:import.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }
    /**
     * @Route("/create", name="admin_product_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $product = $form->getData();
                $productRepository = $this->get('tnqsoft_admin.repository.product');
                $productRepository->persistAndFlush($product);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_product_edit', array('id' => $product->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_product_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Product:create.html.twig',
            array(
                'entity' => $product,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $productRepository = $this->get('tnqsoft_admin.repository.product');
        $productImgRepository = $this->get('tnqsoft_admin.repository.product_img');
        $product = $productRepository->findOneById($id);
        if (null === $product) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }

        $originalPhotos = new ArrayCollection();
        foreach ($product->getListPhoto() as $photo) {
            $originalPhotos->add($photo);
        }

        $form = $this->createForm(ProductType::class, $product);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $product = $form->getData();

                // remove the relationship between the Product and the Photo
                foreach ($originalPhotos as $photo) {
                    if (false === $product->hasPhoto($photo)) {
                        // remove the Task from the Tag
                        $product->removeListPhoto($photo);
                        // if it was a many-to-one relationship, remove the relationship like this
                        // $tag->setTask(null);
                        $productImgRepository->removeAndFlush($photo);
                        // if you wanted to delete the Tag entirely, you can also do that
                        // $em->remove($tag);
                    }
                }

                $productRepository->persistAndFlush($product);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$product->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_product_edit', array('id' => $product->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_product_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Product:edit.html.twig',
            array(
                'entity' => $product,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_product_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $productRepository = $this->get('tnqsoft_admin.repository.product');
        $product = $productRepository->findOneById($id);
        if(null === $product) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $productRepository->removeAndFlush($product);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_product_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_product_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $productRepository = $this->get('tnqsoft_admin.repository.product');
        $product = $productRepository->findOneById($id);
        if(null === $product) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $product->setIsActive(($status==='true'?true:false));
        $productRepository->persistAndFlush($product);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_product_list'));
    }

    /**
     * @Route("/set/new/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_product_set_new")
     * @Method({"GET", "POST"})
     */
    public function setNewAction(Request $request, $id, $status)
    {
        $productRepository = $this->get('tnqsoft_admin.repository.product');
        $product = $productRepository->findOneById($id);
        if(null === $product) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $product->setIsNew(($status==='true'?true:false));
        $productRepository->persistAndFlush($product);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_product_list'));
    }

    /**
     * @Route("/set/special/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_product_set_special")
     * @Method({"GET", "POST"})
     */
    public function setSpecialAction(Request $request, $id, $status)
    {
        $productRepository = $this->get('tnqsoft_admin.repository.product');
        $product = $productRepository->findOneById($id);
        if(null === $product) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $product->setIsSpecial(($status==='true'?true:false));
        $productRepository->persistAndFlush($product);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_product_list'));
    }
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/category/", name="admin_product_category_list")
     */
    public function listPhotoCategoryAction(Request $request)
    {
        $productCategoryRepository = $this->get('tnqsoft_admin.repository.product_category');

        $list = $productCategoryRepository->getTreeList();

        return $this->render('TNQSoftAdminBundle:Product:category_index.html.twig',
            array('list' => $list)
        );
    }

    /**
     * @Route("/category/create", name="admin_product_category_create")
     * @Method({"GET", "POST"})
     */
    public function createPhotoCategoryAction(Request $request)
    {
        $productCategory = new ProductCategory();
        $form = $this->createForm(ProductCategoryType::class, $productCategory);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $productCategory = $form->getData();
                $productCategoryRepository = $this->get('tnqsoft_admin.repository.product_category');
                $productCategoryRepository->persistAndFlush($productCategory);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_product_category_edit', array('id' => $productCategory->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_product_category_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Product:category_create.html.twig',
            array(
                'entity' => $productCategory,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/category/edit/{id}", requirements={"id" = "\d+"}, name="admin_product_category_edit")
     * @Method({"GET", "POST"})
     */
    public function editPhotoCategoryAction(Request $request, $id)
    {
        $productCategoryRepository = $this->get('tnqsoft_admin.repository.product_category');
        $productCategory = $productCategoryRepository->findOneById($id);
        if (null === $productCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(ProductCategoryType::class, $productCategory);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $productCategory = $form->getData();
                //$page->setUpdatedAt();
                $productCategoryRepository->persistAndFlush($productCategory);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$productCategory->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_product_category_edit', array('id' => $productCategory->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_product_category_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Product:category_edit.html.twig',
            array(
                'entity' => $productCategory,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/category/delete/{id}", requirements={"id" = "\d+"}, name="admin_product_category_delete")
     * @Method({"GET", "POST"})
     */
    public function deletePhotoCategoryAction(Request $request, $id)
    {
        $productCategoryRepository = $this->get('tnqsoft_admin.repository.product_category');
        $productCategory = $productCategoryRepository->findOneById($id);
        if(null === $productCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $productCategoryRepository->removeAndFlush($productCategory);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_product_category_list'));
    }

    /**
     * @Route("/category/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_product_category_active")
     * @Method({"GET", "POST"})
     */
    public function activePhotoCategoryAction(Request $request, $id, $status)
    {
        $productCategoryRepository = $this->get('tnqsoft_admin.repository.product_category');
        $productCategory = $productCategoryRepository->findOneById($id);
        if(null === $productCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $productCategory->setIsActive(($status==='true'?true:false));
        $productCategoryRepository->persistAndFlush($productCategory);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_product_category_list'));
    }
}
