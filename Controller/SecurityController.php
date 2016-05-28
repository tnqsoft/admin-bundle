<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TNQSoft\AdminBundle\Form\Model\ChangePassword;
use TNQSoft\AdminBundle\Form\Type\ChangePasswordType;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'TNQSoftAdminBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logoutAction()
    {
    }

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

        return $this->render('TNQSoftAdminBundle:Security:change_pass.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }
}
