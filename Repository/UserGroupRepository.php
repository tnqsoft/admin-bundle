<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\CommonBundle\Service\PaginatorService;
use TNQSoft\CommonBundle\Repository\BaseRepository;

/**
 * Class BannerRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class UserGroupRepository extends BaseRepository
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
        $dql = $this->getRepository()->createQueryBuilder('ug')
                //->leftJoin('Q.listAnswers', 'A')
                ->orderBy('ug.createdAt', 'ASC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

}
