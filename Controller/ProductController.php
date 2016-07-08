<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TNQSoft\AdminBundle\Form\Type\ProductCategoryType;
use TNQSoft\AdminBundle\Entity\ProductCategory;
use TNQSoft\AdminBundle\Form\Type\ProductType;
use TNQSoft\AdminBundle\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;

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

        return $this->render('TNQSoftAdminBundle:Product:index.html.twig',
            array('paginator' => $paginator)
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
