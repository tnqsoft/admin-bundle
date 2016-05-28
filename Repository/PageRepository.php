<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\AdminBundle\Entity\Page;
use TNQSoft\AdminBundle\Service\PaginatorService;

/**
 * Class PageRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class PageRepository extends BaseRepository
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
}
