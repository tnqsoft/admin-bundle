<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\AdminBundle\Service\PaginatorService;

/**
 * Class PhotoCategoryRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class PhotoCategoryRepository extends BaseRepository
{
    /**
     * Get list by pagination
     *
     * @param integer $limit
     * @param boolean $checkActive
     * @return PaginatorService
     */
    public function getListPagination($limit=15, $checkActive=false)
    {
        $query = $this->getRepository()->createQueryBuilder('pc')
                ->orderBy('pc.createdAt', 'DESC');
        if(true === $checkActive) {
            $query->where('pc.isActive = :isActive')
                  ->setParameter('isActive', true);
        }
        $dql = $query->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * Get List For Widget
     *
     * @param  integer $max
     * @return array
     */
    public function getListForWidget($max=10)
    {
        $query = $this->getRepository()->createQueryBuilder('pc')
                ->where('pc.isActive = :isActive')
                ->setParameter('isActive', true)
                ->orderBy('pc.createdAt', 'DESC')
                ->getQuery()
                ->setMaxResults($max);

        return $query->getResult();
    }
}
