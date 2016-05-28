<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\AdminBundle\Form\Type\PhotoCategoryType;
use TNQSoft\AdminBundle\Entity\PhotoCategory;
use TNQSoft\AdminBundle\Form\Type\PhotoType;
use TNQSoft\AdminBundle\Entity\Photo;

/**
 * @Route("/photo")
 */
class PhotoController extends Controller
{

    /**
     * @Route("/", name="admin_photo_list")
     */
    public function indexAction(Request $request)
    {
        $photoRepository = $this->get('tnqsoft_admin.repository.photo');
        $paginator = $photoRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Photo:index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_photo_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $photo = new Photo();

        $form = $this->createForm(PhotoType::class, $photo);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $photo = $form->getData();
                $photoRepository = $this->get('tnqsoft_admin.repository.photo');
                $photoRepository->persistAndFlush($photo);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                return $this->redirect($this->generateUrl('admin_photo_edit', array('id' => $photo->getId())));
            }
        }

        return $this->render('TNQSoftAdminBundle:Photo:create.html.twig',
            array(
                'entity' => $photo,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_photo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $photoRepository = $this->get('tnqsoft_admin.repository.photo');
        $photo = $photoRepository->findOneById($id);
        if (null === $photo) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(PhotoType::class, $photo);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $photo = $form->getData();
                //$photo->setUpdatedAt();
                $photoRepository->persistAndFlush($photo);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$photo->getId().' thành công');

                return $this->redirect($this->generateUrl('admin_photo_edit', array('id' => $photo->getId())));
            }
        }

        return $this->render('TNQSoftAdminBundle:Photo:edit.html.twig',
            array(
                'entity' => $photo,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_photo_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $photoRepository = $this->get('tnqsoft_admin.repository.photo');
        $photo = $photoRepository->findOneById($id);
        if(null === $photo) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $photoRepository->removeAndFlush($photo);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_photo_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_photo_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $photoRepository = $this->get('tnqsoft_admin.repository.photo');
        $photo = $photoRepository->findOneById($id);
        if(null === $photo) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $photo->setIsActive(($status==='true'?true:false));
        $photoRepository->persistAndFlush($photo);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_photo_list'));
    }

    /**
     * @Route("/setdefault/{id}", requirements={"id" = "\d+"}, name="admin_photo_setdefault")
     * @Method({"GET", "POST"})
     */
    public function setDefaultAction(Request $request, $id)
    {
        $photoRepository = $this->get('tnqsoft_admin.repository.photo');
        $photo = $photoRepository->findOneById($id);
        if(null === $photo) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        //Reset default
        $photoRepository->resetDefault($photo->getCategory());
        //Update record current
        $photo->setIsDefault(true);
        $photoRepository->persistAndFlush($photo);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_photo_list'));
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/category/", name="admin_photo_category_list")
     */
    public function listPhotoCategoryAction(Request $request)
    {
        $photoCategoryRepository = $this->get('tnqsoft_admin.repository.photo_category');
        $paginator = $photoCategoryRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:Photo:category_index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/category/create", name="admin_photo_category_create")
     * @Method({"GET", "POST"})
     */
    public function createPhotoCategoryAction(Request $request)
    {
        $photoCategory = new PhotoCategory();
        $form = $this->createForm(PhotoCategoryType::class, $photoCategory);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $photoCategory = $form->getData();
                $photoCategoryRepository = $this->get('tnqsoft_admin.repository.photo_category');
                $photoCategoryRepository->persistAndFlush($photoCategory);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_photo_category_edit', array('id' => $photoCategory->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_photo_category_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Photo:category_create.html.twig',
            array(
                'entity' => $photoCategory,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/category/edit/{id}", requirements={"id" = "\d+"}, name="admin_photo_category_edit")
     * @Method({"GET", "POST"})
     */
    public function editPhotoCategoryAction(Request $request, $id)
    {
        $photoCategoryRepository = $this->get('tnqsoft_admin.repository.photo_category');
        $photoRepository = $this->get('tnqsoft_admin.repository.photo');
        $photoCategory = $photoCategoryRepository->findOneById($id);
        if (null === $photoCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }

        $originalPhotos = new ArrayCollection();
        foreach ($photoCategory->getListPhoto() as $photo) {
            $originalPhotos->add($photo);
        }

        $form = $this->createForm(PhotoCategoryType::class, $photoCategory);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $photoCategory = $form->getData();

                // remove the relationship between the Product and the Photo
                foreach ($originalPhotos as $photo) {
                    if (false === $photoCategory->hasPhoto($photo)) {
                        // remove the Task from the Tag
                        $photoCategory->removeListPhoto($photo);
                        // if it was a many-to-one relationship, remove the relationship like this
                        // $tag->setTask(null);
                        $photoRepository->removeAndFlush($photo);
                        // if you wanted to delete the Tag entirely, you can also do that
                        // $em->remove($tag);
                    }
                }

                $photoCategoryRepository->persistAndFlush($photoCategory);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$photoCategory->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_photo_category_edit', array('id' => $photoCategory->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_photo_category_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:Photo:category_edit.html.twig',
            array(
                'entity' => $photoCategory,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/category/delete/{id}", requirements={"id" = "\d+"}, name="admin_photo_category_delete")
     * @Method({"GET", "POST"})
     */
    public function deletePhotoCategoryAction(Request $request, $id)
    {
        $photoCategoryRepository = $this->get('tnqsoft_admin.repository.photo_category');
        $photoCategory = $photoCategoryRepository->findOneById($id);
        if(null === $photoCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $photoCategoryRepository->removeAndFlush($photoCategory);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_photo_category_list'));
    }

    /**
     * @Route("/category/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_photo_category_active")
     * @Method({"GET", "POST"})
     */
    public function activePhotoCategoryAction(Request $request, $id, $status)
    {
        $photoCategoryRepository = $this->get('tnqsoft_admin.repository.photo_category');
        $photoCategory = $photoCategoryRepository->findOneById($id);
        if(null === $photoCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $photoCategory->setIsActive(($status==='true'?true:false));
        $photoCategoryRepository->persistAndFlush($photoCategory);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_photo_category_list'));
    }

    /**
     * Get Category
     *
     * @param  integer $id
     * @return PhotoCategory
     */
    private function getCategory($id)
    {
        $photoCategoryRepository = $this->get('tnqsoft_admin.repository.photo_category');
        $photoCategory = $photoCategoryRepository->findOneById($id);
        if(null === $photoCategory) {
            throw new HttpException(404, 'Không tìm thấy Danh mục có id là '.$id);
        }

        return $photoCategory;
    }
}
