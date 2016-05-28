<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\AdminBundle\Service\PaginatorService;

/**
 * Class TestimonialRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class TestimonialRepository extends BaseRepository
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
        $query = $this->getRepository()->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC');
        if(true === $checkActive) {
            $query->where('t.isActive = :isActive')
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
        $query = $this->getRepository()->createQueryBuilder('t')
                ->where('t.isActive = :isActive')
                ->setParameter('isActive', true)
                ->orderBy('t.createdAt', 'DESC')
                ->getQuery()
                ->setMaxResults($max);

        return $query->getResult();
    }
}
