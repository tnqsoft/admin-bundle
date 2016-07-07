<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\CommonBundle\Service\PaginatorService;
use TNQSoft\CommonBundle\Repository\BaseRepository;
use TNQSoft\AdminBundle\Entity\NewsCategory;

/**
 * Class NewsRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class NewsRepository extends BaseRepository
{
    /**
     * Get list by pagination
     *
     * @param integer $limit
     * @return PaginatorService
     * @internal param int $page
     */
    public function getListPagination($limit=15)
    {
        $dql = $this->getRepository()->createQueryBuilder('n')
                //->leftJoin('Q.listAnswers', 'A')
                ->orderBy('n.createdAt', 'DESC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * Get List For Widget
     *
     * @param  integer $max
     * @return array
     */
    public function getListForWidget($max=5)
    {
        $query = $this->getRepository()->createQueryBuilder('n')
                ->where('n.isActive = :isActive')
                ->setParameter('isActive', true)
                ->orderBy('n.createdAt', 'DESC')
                ->getQuery()
                ->setMaxResults($max);

        return $query->getResult();
    }

    /**
     * Get List Pagination By Category
     *
     * @param  NewsCategory $category
     * @param  integer      $limit
     * @return PaginatorService
     */
    public function getListPaginationByCategory(NewsCategory $category, $limit=15)
    {
        $dql = $this->getRepository()->createQueryBuilder('n')
                //->leftJoin('Q.listAnswers', 'A')
                ->where('n.isActive = :isActive')
                ->andWhere('n.category = :category')
                ->setParameter('isActive', true)
                ->setParameter('category', $category)
                ->orderBy('n.createdAt', 'DESC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * @param NewsCategory $category
     * @param News $currentItem
     * @param int $max
     */
    public function getRelatedList($category, $currentItem, $max=15)
    {
        $query = $this->getRepository()->createQueryBuilder('n')
            ->where('n.isActive = :isActive')
            ->andWhere('n.category = :category')
            ->andWhere('n.id != :id')
            ->setParameter('isActive', true)
            ->setParameter('category', $category)
            ->setParameter('id', $currentItem->getId())
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()
            ->setMaxResults($max);

        return $query->getResult();
    }
}
