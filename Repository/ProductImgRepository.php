<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\AdminBundle\Service\PaginatorService;

/**
 * Class ProductImgRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class ProductImgRepository extends BaseRepository
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
        $dql = $this->getRepository()->createQueryBuilder('pi')
                //->leftJoin('Q.listAnswers', 'A')
                ->orderBy('pi.createdAt', 'DESC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }
}
