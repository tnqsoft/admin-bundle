<?php

namespace TNQSoft\AdminBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TNQSoft\AdminBundle\Form\Type\NewsCategoryType;
use TNQSoft\AdminBundle\Entity\NewsCategory;
use TNQSoft\AdminBundle\Form\Type\NewsType;
use TNQSoft\AdminBundle\Entity\News;

/**
 * @Route("/news")
 */
class NewsController extends Controller
{

    /**
     * @Route("/", name="admin_news_list")
     */
    public function indexAction(Request $request)
    {
        $newsRepository = $this->get('tnqsoft_admin.repository.news');
        $paginator = $newsRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:News:index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/create", name="admin_news_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $news = new News();

        $form = $this->createForm(NewsType::class, $news);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $news = $form->getData();
                $newsRepository = $this->get('tnqsoft_admin.repository.news');
                $newsRepository->persistAndFlush($news);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_news_edit', array('id' => $news->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_news_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:News:create.html.twig',
            array(
                'entity' => $news,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="admin_news_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $newsRepository = $this->get('tnqsoft_admin.repository.news');
        $news = $newsRepository->findOneById($id);
        if (null === $news) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(NewsType::class, $news);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $news = $form->getData();
                //$news->setUpdatedAt();
                $newsRepository->persistAndFlush($news);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$news->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_news_edit', array('id' => $news->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_news_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:News:edit.html.twig',
            array(
                'entity' => $news,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="admin_news_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $newsRepository = $this->get('tnqsoft_admin.repository.news');
        $news = $newsRepository->findOneById($id);
        if(null === $news) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $newsRepository->removeAndFlush($news);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_news_list'));
    }

    /**
     * @Route("/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_news_active")
     * @Method({"GET", "POST"})
     */
    public function activeAction(Request $request, $id, $status)
    {
        $newsRepository = $this->get('tnqsoft_admin.repository.news');
        $news = $newsRepository->findOneById($id);
        if(null === $news) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $news->setIsActive(($status==='true'?true:false));
        $newsRepository->persistAndFlush($news);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_news_list'));
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/category/", name="admin_news_category_list")
     */
    public function listNewsCategoryAction(Request $request)
    {
        $newsCategoryRepository = $this->get('tnqsoft_admin.repository.news_category');
        $paginator = $newsCategoryRepository->getListPagination();
        $paginator->setContainer($this->container);
        $paginator->setRequest($request);

        return $this->render('TNQSoftAdminBundle:News:category_index.html.twig',
            array('paginator' => $paginator)
        );
    }

    /**
     * @Route("/category/create", name="admin_news_category_create")
     * @Method({"GET", "POST"})
     */
    public function createNewsCategoryAction(Request $request)
    {
        $newsCategory = new NewsCategory();
        $form = $this->createForm(NewsCategoryType::class, $newsCategory);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $newsCategory = $form->getData();
                $newsCategoryRepository = $this->get('tnqsoft_admin.repository.news_category');
                $newsCategoryRepository->persistAndFlush($newsCategory);
                $request->getSession()->getFlashBag()->add('success', 'Tạo bản ghi thành công');

                $urlRedirect = $this->generateUrl('admin_news_category_edit', array('id' => $newsCategory->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_news_category_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:News:category_create.html.twig',
            array(
                'entity' => $newsCategory,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/category/edit/{id}", requirements={"id" = "\d+"}, name="admin_news_category_edit")
     * @Method({"GET", "POST"})
     */
    public function editNewsCategoryAction(Request $request, $id)
    {
        $newsCategoryRepository = $this->get('tnqsoft_admin.repository.news_category');
        $newsCategory = $newsCategoryRepository->findOneById($id);
        if (null === $newsCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $form = $this->createForm(NewsCategoryType::class, $newsCategory);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $newsCategory = $form->getData();
                //$page->setUpdatedAt();
                $newsCategoryRepository->persistAndFlush($newsCategory);
                $request->getSession()->getFlashBag()->add('success', 'Cập nhật bản ghi có id '.$newsCategory->getId().' thành công');

                $urlRedirect = $this->generateUrl('admin_news_category_edit', array('id' => $newsCategory->getId()));
                if($form->get('saveAndAdd')->isClicked()) {
                    $urlRedirect = $this->generateUrl('admin_news_category_create');
                }
                return $this->redirect($urlRedirect);
            }
        }

        return $this->render('TNQSoftAdminBundle:News:category_edit.html.twig',
            array(
                'entity' => $newsCategory,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/category/delete/{id}", requirements={"id" = "\d+"}, name="admin_news_category_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteNewsCategoryAction(Request $request, $id)
    {
        $newsCategoryRepository = $this->get('tnqsoft_admin.repository.news_category');
        $newsCategory = $newsCategoryRepository->findOneById($id);
        if(null === $newsCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $newsCategoryRepository->removeAndFlush($newsCategory);
        $request->getSession()->getFlashBag()->add('warning', 'Xóa bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_news_category_list'));
    }

    /**
     * @Route("/category/active/{id}/{status}", requirements={"id" = "\d+" ,"status" = "true|false"}, name="admin_news_category_active")
     * @Method({"GET", "POST"})
     */
    public function activeNewsCategoryAction(Request $request, $id, $status)
    {
        $newsCategoryRepository = $this->get('tnqsoft_admin.repository.news_category');
        $newsCategory = $newsCategoryRepository->findOneById($id);
        if(null === $newsCategory) {
            throw new HttpException(404, 'Không tìm thấy bản ghi có id là '.$id);
        }
        $newsCategory->setIsActive(($status==='true'?true:false));
        $newsCategoryRepository->persistAndFlush($newsCategory);
        $request->getSession()->getFlashBag()->add('warning', 'Cập nhật bản ghi có id là '.$id.' thành công');
        return $this->redirect($this->generateUrl('admin_news_category_list'));
    }

    /**
     * Get Category
     *
     * @param  integer $id
     * @return NewsCategory
     */
    private function getCategory($id)
    {
        $newsCategoryRepository = $this->get('tnqsoft_admin.repository.news_category');
        $newsCategory = $newsCategoryRepository->findOneById($id);
        if(null === $newsCategory) {
            throw new HttpException(404, 'Không tìm thấy Danh mục có id là '.$id);
        }

        return $newsCategory;
    }
}
