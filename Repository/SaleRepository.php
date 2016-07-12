<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\CommonBundle\Service\PaginatorService;
use TNQSoft\CommonBundle\Repository\BaseRepository;
use TNQSoft\AdminBundle\Entity\Sale;

/**
 * Class SaleRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class SaleRepository extends BaseRepository
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
        $dql = $this->getRepository()->createQueryBuilder('s')
                //->leftJoin('Q.listAnswers', 'A')
                ->orderBy('s.createdAt', 'DESC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

}
