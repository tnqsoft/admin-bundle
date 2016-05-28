<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TNQSoft\AdminBundle\Form\Type\PartnerType;
use TNQSoft\AdminBundle\Entity\Partner;

/**
 * @Route("/partner")
 */
class PartnerController extends Controller
{

    /**
     * @Route("/", name="admin_partner_list")
     */
    public function indexAction(Request $request)
    {
        $partnerRepository = $this->get('tnqsoft_admin.repository.partner');
        $paginator = $partnerRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Partner:index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_partner_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $partner = new Partner();

        $form = $this->createForm(PartnerType::class, $partner);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $partner = $form->getData();
                $partnerRepository = $this->get('tnqsoft_admin.repository.partner');
                $partnerRepository->persistAndFlush($partner);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_partner_edit', array('id' => $partner->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_partner_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Partner:create.html.twig',
            array(
                'entity' => $partner,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_partner_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $partnerRepository = $this->get('tnqsoft_admin.repository.partner');
        $partner = $partnerRepository->findOneById($id);
        if (null === $partner) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(PartnerType::class, $partner);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $partner = $form->getData();
                //$partner->setUpdatedAt();
                $partnerRepository->persistAndFlush($partner);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$partner->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_partner_edit', array('id' => $partner->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_partner_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Partner:edit.html.twig',
            array(
                'entity' => $partner,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_partner_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $partnerRepository = $this->get('tnqsoft_admin.repository.partner');
        $partner = $partnerRepository->findOneById($id);
        if(null === $partner) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $partnerRepository->removeAndFlush($partner);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_partner_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_partner_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $partnerRepository = $this->get('tnqsoft_admin.repository.partner');
        $partner = $partnerRepository->findOneById($id);
        if(null === $partner) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $partner->setIsActive(($status==='true'?true:false));
        $partnerRepository->persistAndFlush($partner);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_partner_list'));
    }

}
