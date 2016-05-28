<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TNQSoft\AdminBundle\Form\Type\MenuType;
use TNQSoft\AdminBundle\Entity\Menu;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Route("/menu")
 */
class MenuController extends Controller
{    
    /**
     * @Route("/", name="admin_menu_list")
     */
    public function indexAction(Request $request)
    {
        $menuRepository = $this->get('tnqsoft_admin.repository.menu');
        $list = $menuRepository->getTreeList2();

        return $this->render('TNQSoftAdminBundle:Menu:index.html.twig',
            array('list' => $list)
        );
    }

    /**
     * @Route("/sort", name="admin_menu_sort")
     */
    public function sortAction(Request $request)
    {
        $menuRepository = $this->get('tnqsoft_admin.repository.menu');
        $menus = $menuRepository->getTreeList2(false);

        if ($request->isMethod('POST')) {
            $listItemsJson = $request->request->get('listItems', '[]');
            $listItems = json_decode($listItemsJson);
            if(count($listItems) > 0) {
                foreach ($listItems as $item) {
                    $menu = $menuRepository->findOneById(intval($item->id, 10));
                    if (null !== $menu) {
                        $menu->setLvl($item->depth);
                        $menu->setLft($item->left);
                        $menu->setRgt($item->right);
                        $menu->setParent(null);
                        if(null !== $item->parent_id) {
                            $parent = $menuRepository->findOneById(intval($item->parent_id, 10));
                            if(null !== $parent) {
                                $menu->setParent($parent);
                            }
                        }
                        $menuRepository->persist($menu);
                    }
                }
                $menuRepository->flush();
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật thứ tự thành công');
                return $this->redirect($this->generateUrl('admin_menu_sort'));
            }
        }

        return $this->render('TNQSoftAdminBundle:Menu:sort.html.twig',
            array('menus' => $menus)
        );
    }

    /**
     * @Route("/create", name="admin_menu_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $menu = $form->getData();
                $menuRepository = $this->get('tnqsoft_admin.repository.menu');
                $menuRepository->persistAndFlush($menu);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_menu_edit', array('id' => $menu->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_menu_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Menu:create.html.twig',
            array(
                'entity' => $menu,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_menu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $menuRepository = $this->get('tnqsoft_admin.repository.menu');
        $menu = $menuRepository->findOneById($id);
        if (null === $menu) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(MenuType::class, $menu);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $menu = $form->getData();
                $menuRepository->persistAndFlush($menu);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$menu->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_menu_edit', array('id' => $menu->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_menu_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Menu:edit.html.twig',
            array(
                'entity' => $menu,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_menu_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $menuRepository = $this->get('tnqsoft_admin.repository.menu');
        $menu = $menuRepository->findOneById($id);
        if(null === $menu) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $menuRepository->removeAndFlush($menu);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_menu_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_menu_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $menuRepository = $this->get('tnqsoft_admin.repository.menu');
        $menu = $menuRepository->findOneById($id);
        if(null === $menu) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $menu->setIsActive(($status==='true'?true:false));
        $menuRepository->persistAndFlush($menu);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_menu_list'));
    }
}
