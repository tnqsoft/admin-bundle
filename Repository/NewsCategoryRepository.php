<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\AdminBundle\Service\PaginatorService;

/**
 * Class NewsCategoryRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class NewsCategoryRepository extends BaseRepository
{
    /**
     * Get list by pagination
     *
     * @param integer $limit
     * @return PaginatorService
     */
    public function getListPagination($limit=15)
    {
        $dql = $this->getRepository()->createQueryBuilder('nc')
                //->leftJoin('Q.listAnswers', 'A')
                ->orderBy('nc.createdAt', 'DESC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }
}
