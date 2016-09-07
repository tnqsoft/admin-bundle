<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\AdminBundle\Form\Type\UserGroupType;
use TNQSoft\AdminBundle\Entity\UserGroup;

/**
 * @Route("/user/group")
 */
class UserGroupController extends Controller
{

    /**
     * @Route("/", name="admin_user_group_list")
     */
    public function indexAction(Request $request)
    {
        $userGroupRepository = $this->get('tnqsoft_admin.repository.user_group');
        $paginator = $userGroupRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Security:Group/index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_user_group_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $userGroup = new UserGroup();

        $form = $this->createForm(UserGroupType::class, $userGroup);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $userGroup = $form->getData();
                $userGroupRepository = $this->get('tnqsoft_admin.repository.user_group');
                $userGroupRepository->persistAndFlush($userGroup);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_user_group_edit', array('id' => $userGroup->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_user_group_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Security:Group/create.html.twig',
            array(
                'entity' => $userGroup,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_user_group_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $userGroupRepository = $this->get('tnqsoft_admin.repository.user_group');
        $userGroup = $userGroupRepository->findOneById($id);
        if (null === $userGroup) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(UserGroupType::class, $userGroup);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $userGroup = $form->getData();
                //$userGroup->setUpdatedAt();
                $userGroupRepository->persistAndFlush($userGroup);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$userGroup->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_user_group_edit', array('id' => $userGroup->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_user_group_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Security:Group/edit.html.twig',
            array(
                'entity' => $userGroup,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_user_group_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $userGroupRepository = $this->get('tnqsoft_admin.repository.user_group');
        $userGroup = $userGroupRepository->findOneById($id);
        if(null === $userGroup) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $userGroupRepository->removeAndFlush($userGroup);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_user_group_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_user_group_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $userGroupRepository = $this->get('tnqsoft_admin.repository.user_group');
        $userGroup = $userGroupRepository->findOneById($id);
        if(null === $userGroup) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $userGroup->setIsActive(($status==='true'?true:false));
        $userGroupRepository->persistAndFlush($userGroup);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_user_group_list'));
    }
}
