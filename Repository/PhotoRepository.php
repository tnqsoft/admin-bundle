<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\CommonBundle\Service\PaginatorService;
use TNQSoft\CommonBundle\Repository\BaseRepository;
use TNQSoft\AdminBundle\Entity\PhotoCategory;

/**
 * Class PhotoRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class PhotoRepository extends BaseRepository
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

    /**
     * Reset Default
     *
     * @param PhotoCategory $category
     */
    public function resetDefault(PhotoCategory $category)
    {
        return $this->getRepository()->createQueryBuilder('p')
                ->update()
                ->set('p.isDefault', 0)
                ->where('p.category = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->execute();
    }

}
