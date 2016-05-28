<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TNQSoft\AdminBundle\Form\Type\PageType;
use TNQSoft\AdminBundle\Entity\Page;

/**
 * @Route("/page")
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="admin_page_list")
     */
    public function indexAction(Request $request)
    {
        $pageRepository = $this->get('tnqsoft_admin.repository.page');
        $paginator = $pageRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Page:index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_page_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $page = $form->getData();
                $pageRepository = $this->get('tnqsoft_admin.repository.page');
                $pageRepository->persistAndFlush($page);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_page_edit', array('id' => $page->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_page_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Page:create.html.twig',
            array(
                'entity' => $page,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_page_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $pageRepository = $this->get('tnqsoft_admin.repository.page');
        $page = $pageRepository->findOneById($id);
        if (null === $page) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(PageType::class, $page);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $page = $form->getData();
                //$page->setUpdatedAt();
                $pageRepository->persistAndFlush($page);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$page->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_page_edit', array('id' => $page->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_page_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Page:edit.html.twig',
            array(
                'entity' => $page,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_page_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $pageRepository = $this->get('tnqsoft_admin.repository.page');
        $page = $pageRepository->findOneById($id);
        if(null === $page) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $pageRepository->removeAndFlush($page);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_page_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_page_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $pageRepository = $this->get('tnqsoft_admin.repository.page');
        $page = $pageRepository->findOneById($id);
        if(null === $page) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $page->setIsActive(($status==='true'?true:false));
        $pageRepository->persistAndFlush($page);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_page_list'));
    }
}
