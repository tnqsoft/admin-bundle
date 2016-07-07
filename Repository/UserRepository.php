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
}
