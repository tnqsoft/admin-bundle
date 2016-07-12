<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TNQSoft\AdminBundle\Form\Type\SaleType;
use TNQSoft\AdminBundle\Entity\Product;
use TNQSoft\AdminBundle\Entity\Sale;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("/sale")
 */
class SaleController extends Controller
{
    /**
     * @Route("/", name="admin_sale_list")
     */
    public function indexAction(Request $request)
    {
        $saleRepository = $this->get('tnqsoft_admin.repository.sale');
        $paginator = $saleRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Sale:index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_sale_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $sale = new Sale();

        $form = $this->createForm(SaleType::class, $sale);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sale = $form->getData();

                $productRepository = $this->get('tnqsoft_admin.repository.product');
                if(!empty($sale->getProductsId())) {
                    $ids = explode(",", $sale->getProductsId());
                    foreach ($ids as $productId) {
                        $product = $productRepository->findOneById($productId);
                        if(null !== $product) {
                            $sale->addProduct($product);
                        }
                    }
                }

                $saleRepository = $this->get('tnqsoft_admin.repository.sale');
                $saleRepository->persistAndFlush($sale);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_sale_edit', array('id' => $sale->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_sale_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Sale:create.html.twig',
            array(
                'entity' => $sale,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_sale_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $saleRepository = $this->get('tnqsoft_admin.repository.sale');
        $sale = $saleRepository->findOneById($id);
        if (null === $sale) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(SaleType::class, $sale);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sale = $form->getData();

                $productRepository = $this->get('tnqsoft_admin.repository.product');
                if(!empty($sale->getProductsId())) {
                    $ids = explode(",", $sale->getProductsId());
                    foreach ($ids as $productId) {
                        $product = $productRepository->findOneById($productId);
                        if(null !== $product) {
                            $sale->addProduct($product);
                        }
                    }
                }

                $saleRepository->persistAndFlush($sale);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$sale->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_sale_edit', array('id' => $sale->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_sale_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Sale:edit.html.twig',
            array(
                'entity' => $sale,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_sale_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $saleRepository = $this->get('tnqsoft_admin.repository.sale');
        $sale = $saleRepository->findOneById($id);
        if(null === $sale) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $saleRepository->removeAndFlush($sale);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_sale_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_sale_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $saleRepository = $this->get('tnqsoft_admin.repository.sale');
        $sale = $saleRepository->findOneById($id);
        if(null === $sale) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $sale->setIsActive(($status==='true'?true:false));
        $saleRepository->persistAndFlush($sale);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_sale_list'));
    }

}