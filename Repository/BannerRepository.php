<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\AdminBundle\Service\PaginatorService;

/**
 * Class BannerRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class BannerRepository extends BaseRepository
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
        $dql = $this->getRepository()->createQueryBuilder('b')
                //->leftJoin('Q.listAnswers', 'A')
                ->orderBy('b.position', 'ASC')
                ->addOrderBy('b.ordering', 'ASC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

}
