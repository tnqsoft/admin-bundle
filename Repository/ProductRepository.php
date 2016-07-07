<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\CommonBundle\Service\PaginatorService;
use TNQSoft\CommonBundle\Repository\BaseRepository;
use TNQSoft\AdminBundle\Entity\ProductCategory;
use TNQSoft\AdminBundle\Entity\Partner;

/**
 * Class ProductRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class ProductRepository extends BaseRepository
{
    /**
     * Get list by pagination
     *
     * @param integer $page
     * @param integer $limit
     * @return PaginatorService
     */
    public function getListPagination($limit=15)
    {
        $dql = $this->getRepository()->createQueryBuilder('p')
                //->leftJoin('Q.listAnswers', 'A')
                ->orderBy('p.createdAt', 'DESC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * Get List For Widget
     *
     * @param  integer $max
     * @return array
     */
    public function getListForWidget($max=5, $orderby='createdAt', $direct='DESC')
    {
        $query = $this->getRepository()->createQueryBuilder('p')
            ->where('p.isActive = :isActive')
            ->setParameter('isActive', true)
            ->orderBy('p.'.$orderby, $direct)
            ->getQuery()
            ->setMaxResults($max);

        return $query->getResult();
    }

    /**
     * Get List Pagination By Category
     *
     * @param  ProductCategory $category
     * @param  integer      $limit
     * @param  string $orderby
     * @param  string $direct
     * @return PaginatorService
     */
    public function getListPaginationByCategory(ProductCategory $category, $limit=15, $orderby='createdAt', $direct='DESC')
    {
        $dql = $this->getRepository()->createQueryBuilder('p')
            //->leftJoin('Q.listAnswers', 'A')
            ->where('p.isActive = :isActive')
            ->andWhere('p.category = :category')
            ->setParameter('isActive', true)
            ->setParameter('category', $category)
            ->orderBy('p.'.$orderby, $direct)
            ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * Get List Pagination By Parent Category
     *
     * @param  ProductCategory $parentCategory
     * @param  integer      $limit
     * @param  string $orderby
     * @param  string $direct
     * @return PaginatorService
     */
    public function getListPaginationByParentCategory(ProductCategory $parentCategory, $limit=15, $orderby='createdAt', $direct='DESC')
    {
        $dql = $this->getRepository()->createQueryBuilder('p')
            //->leftJoin('Q.listAnswers', 'A')
            ->where('p.isActive = :isActive')
            ->andWhere('p.category IN (:categories)')
            ->setParameter('isActive', true)
            ->setParameter('categories', $parentCategory->getChildren())
            ->orderBy('p.'.$orderby, $direct)
            ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * Get List Pagination By Partner
     *
     * @param  Partner $partner
     * @param  integer      $limit
     * @param  string $orderby
     * @param  string $direct
     * @return PaginatorService
     */
    public function getListPaginationByPartner(Partner $partner, $limit=15, $orderby='createdAt', $direct='DESC')
    {
        $dql = $this->getRepository()->createQueryBuilder('p')
            //->leftJoin('Q.listAnswers', 'A')
            ->where('p.isActive = :isActive')
            ->andWhere('p.partner = :partner')
            ->setParameter('isActive', true)
            ->setParameter('partner', $partner)
            ->orderBy('p.'.$orderby, $direct)
            ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * Get List Pagination By Search
     *
     * @param  string $keyword
     * @param  integer      $limit
     * @param  string $orderby
     * @param  string $direct
     * @return PaginatorService
     */
    public function getListPaginationBySearch($keyword, $limit=15, $orderby='createdAt', $direct='DESC')
    {
        $dql = $this->getRepository()->createQueryBuilder('p')
            //->leftJoin('Q.listAnswers', 'A')
            ->where('p.isActive = :isActive')
            ->andWhere('p.upc LIKE :keyword OR p.title LIKE :keyword OR p.summary LIKE :keyword OR p.content LIKE :keyword')
            ->setParameter('isActive', true)
            ->setParameter('keyword', '%'.$keyword.'%')
            ->orderBy('p.'.$orderby, $direct)
            ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * Get All By Category
     *
     * @param  ProductCategory $category
     * @param  integer $max
     * @return PaginatorService
     */
    public function getAllByCategory(ProductCategory $category, $max=6)
    {
        $query = $this->getRepository()->createQueryBuilder('p')
            //->leftJoin('Q.listAnswers', 'A')
            ->where('p.isActive = :isActive')
            ->andWhere('p.category IN (:categories)')
            ->setParameter('isActive', true)
            ->setParameter('categories', $category->getChildren())
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->setMaxResults($max);

        return $query->getResult();
    }

    /**
     * @param ProductCategory $category
     * @param Product $currentItem
     * @param int $max
     */
    public function getRelatedList($category, $currentItem, $max=6)
    {
        $query = $this->getRepository()->createQueryBuilder('p')
            ->where('p.isActive = :isActive')
            ->andWhere('p.category = :category')
            ->andWhere('p.id != :id')
            ->setParameter('isActive', true)
            ->setParameter('category', $category)
            ->setParameter('id', $currentItem->getId())
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->setMaxResults($max);

        return $query->getResult();
    }
}
