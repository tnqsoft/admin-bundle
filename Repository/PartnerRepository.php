<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\AdminBundle\Service\PaginatorService;

/**
 * Class PartnerRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class PartnerRepository extends BaseRepository
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
                ->orderBy('p.createdAt', 'DESC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }
}
