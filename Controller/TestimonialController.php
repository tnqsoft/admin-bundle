<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TNQSoft\AdminBundle\Form\Type\TestimonialType;
use TNQSoft\AdminBundle\Entity\Testimonial;

/**
 * @Route("/testimonial")
 */
class TestimonialController extends Controller
{

    /**
     * @Route("/", name="admin_testimonial_list")
     */
    public function indexAction(Request $request)
    {
        $testimonialRepository = $this->get('tnqsoft_admin.repository.testimonial');
        $paginator = $testimonialRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Testimonial:index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_testimonial_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $testimonial = new Testimonial();

        $form = $this->createForm(TestimonialType::class, $testimonial);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $testimonial = $form->getData();
                $testimonialRepository = $this->get('tnqsoft_admin.repository.testimonial');
                $testimonialRepository->persistAndFlush($testimonial);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_testimonial_edit', array('id' => $testimonial->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_testimonial_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Testimonial:create.html.twig',
            array(
                'entity' => $testimonial,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_testimonial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $testimonialRepository = $this->get('tnqsoft_admin.repository.testimonial');
        $testimonial = $testimonialRepository->findOneById($id);
        if (null === $testimonial) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(TestimonialType::class, $testimonial);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $testimonial = $form->getData();
                //$testimonial->setUpdatedAt();
                $testimonialRepository->persistAndFlush($testimonial);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$testimonial->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_testimonial_edit', array('id' => $testimonial->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_testimonial_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Testimonial:edit.html.twig',
            array(
                'entity' => $testimonial,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_testimonial_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $testimonialRepository = $this->get('tnqsoft_admin.repository.testimonial');
        $testimonial = $testimonialRepository->findOneById($id);
        if(null === $testimonial) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $testimonialRepository->removeAndFlush($testimonial);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_testimonial_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_testimonial_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $testimonialRepository = $this->get('tnqsoft_admin.repository.testimonial');
        $testimonial = $testimonialRepository->findOneById($id);
        if(null === $testimonial) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $testimonial->setIsActive(($status==='true'?true:false));
        $testimonialRepository->persistAndFlush($testimonial);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_testimonial_list'));
    }

}
