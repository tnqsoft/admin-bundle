<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\AdminBundle\Form\Type\BannerType;
use TNQSoft\AdminBundle\Entity\Banner;

/**
 * @Route("/banner")
 */
class BannerController extends Controller
{

    /**
     * @Route("/", name="admin_banner_list")
     */
    public function indexAction(Request $request)
    {
        $bannerRepository = $this->get('tnqsoft_admin.repository.banner');
        $paginator = $bannerRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Banner:index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_banner_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $banner = new Banner();

        $form = $this->createForm(BannerType::class, $banner);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $banner = $form->getData();
                $bannerRepository = $this->get('tnqsoft_admin.repository.banner');
                $bannerRepository->persistAndFlush($banner);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_banner_edit', array('id' => $banner->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_banner_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Banner:create.html.twig',
            array(
                'entity' => $banner,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_banner_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $bannerRepository = $this->get('tnqsoft_admin.repository.banner');
        $banner = $bannerRepository->findOneById($id);
        if (null === $banner) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(BannerType::class, $banner);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $banner = $form->getData();
                //$banner->setUpdatedAt();
                $bannerRepository->persistAndFlush($banner);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$banner->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_banner_edit', array('id' => $banner->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_banner_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Banner:edit.html.twig',
            array(
                'entity' => $banner,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_banner_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $bannerRepository = $this->get('tnqsoft_admin.repository.banner');
        $banner = $bannerRepository->findOneById($id);
        if(null === $banner) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $bannerRepository->removeAndFlush($banner);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_banner_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_banner_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $bannerRepository = $this->get('tnqsoft_admin.repository.banner');
        $banner = $bannerRepository->findOneById($id);
        if(null === $banner) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $banner->setIsActive(($status==='true'?true:false));
        $bannerRepository->persistAndFlush($banner);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_banner_list'));
    }
}
