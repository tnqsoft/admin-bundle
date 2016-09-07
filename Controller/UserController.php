<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\AdminBundle\Form\Type\UserType;
use TNQSoft\AdminBundle\Entity\User;
use TNQSoft\AdminBundle\Form\Model\ChangePassword;
use TNQSoft\AdminBundle\Form\Type\ChangePasswordType;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
    * @Route("/change_pass", name="admin_change_password")
    */
    public function changePasswordAction(Request $request)
    {
        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePasswordModel);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $changePasswordModel = $form->getData();
                $userRepository = $this->get('tnqsoft_admin.repository.user');
                $user = $userRepository->findOneById($this->getUser()->getId());
                $passwordEncoder = $this->get('security.password_encoder');
                $password = $passwordEncoder->encodePassword($user, $changePasswordModel->getNewPassword());
                $user->setPassword($password);
                $userRepository->persistAndFlush($user);
                $request->getSession()->getFlashBag()->add('success', 'Đổi mật khẩu mới thành công');

                return $this->redirect($this->generateUrl('admin_change_password'));
            }
        }

        return $this->render('TNQSoftAdminBundle:Security:User/change_pass.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/", name="admin_user_list")
     */
    public function indexAction(Request $request)
    {
        $userRepository = $this->get('tnqsoft_admin.repository.user');
        $paginator = $userRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Security:User/index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_user_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $form->getData();
                if($user->getNewPassword() !== '') {
                    $passwordEncoder = $this->get('security.password_encoder');
                    $password = $passwordEncoder->encodePassword($user, $user->getNewPassword());
                    $user->setPassword($password);
                }
                $userRepository = $this->get('tnqsoft_admin.repository.user');
                $userRepository->persistAndFlush($user);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_user_edit', array('id' => $user->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_user_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Security:User/create.html.twig',
            array(
                'entity' => $user,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $userRepository = $this->get('tnqsoft_admin.repository.user');
        $user = $userRepository->findOneById($id);
        if (null === $user) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(UserType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $form->getData();
                if($user->getNewPassword() !== '') {
                    $passwordEncoder = $this->get('security.password_encoder');
                    $password = $passwordEncoder->encodePassword($user, $user->getNewPassword());
                    $user->setPassword($password);
                }
                //$user->setUpdatedAt();
                $userRepository->persistAndFlush($user);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$user->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_user_edit', array('id' => $user->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_user_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Security:User/edit.html.twig',
            array(
                'entity' => $user,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_user_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $userRepository = $this->get('tnqsoft_admin.repository.user');
        $user = $userRepository->findOneById($id);
        if(null === $user) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $userRepository->removeAndFlush($user);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_user_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_user_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $userRepository = $this->get('tnqsoft_admin.repository.user');
        $user = $userRepository->findOneById($id);
        if(null === $user) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $user->setIsActive(($status==='true'?true:false));
        $userRepository->persistAndFlush($user);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_user_list'));
    }
}
