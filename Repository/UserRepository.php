<?php

namespace TNQSoft\AdminBundle\Repository;

use TNQSoft\CommonBundle\Service\PaginatorService;
use TNQSoft\CommonBundle\Repository\BaseRepository;
use TNQSoft\AdminBundle\Entity\User;

/**
 * Class UserRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class UserRepository extends BaseRepository
{
    /**
     * @param $username
     * @return mixed
     */
    public function loadUserByUsername($username)
    {
        return $this->getRepository()->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get list by pagination
     *
     * @param integer $page
     * @param integer $limit
     * @return PaginatorService
     */
    public function getListPagination($limit=15)
    {
        $dql = $this->getRepository()->createQueryBuilder('u')
                //->leftJoin('Q.listAnswers', 'A')
                ->orderBy('u.createdAt', 'ASC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }
}
