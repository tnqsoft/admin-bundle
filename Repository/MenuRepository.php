<?php

namespace TNQSoft\AdminBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\AdminBundle\Service\PaginatorService;
use TNQSoft\AdminBundle\Entity\Menu;

/**
 * Class MenuRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class MenuRepository extends BaseNestedTreeRepository
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
        $dql = $this->getRepository()->createQueryBuilder('m')
                ->orderBy('m.createdAt', 'DESC')
                ->getQuery();

        return new PaginatorService($dql, 1, $limit);
    }

    /**
     * Get Tree List
     *
     * @return array
     */
    public function getTreeList($transform = true)
    {
        $options = array(
            'decorate' => false,
        );
        $treeList = $this->childrenHierarchy(null, false, $options);

        if(true === $transform) {
            return $this->transformTreeList($treeList);
        }

        return $treeList;
    }

    /**
     * Get Tree List 2
     *
     * @param bool $transform
     * @return array
     */
    public function getTreeList2($transform = true, $isActive=null)
    {
        $qb = $this->getNodesHierarchyQueryBuilder();
        $qb
            ->orderBy('node.lft', 'ASC')
            ->addOrderBy('node.root', 'ASC')
        ;

        if(null !== $isActive) {
            $qb
                ->andWhere('node.isActive = :status')
                ->setParameter('status', $isActive)
            ;
        }

        $aComponents = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        if(true === $transform) {
            return $this->transformTreeList($this->buildTreeArray($aComponents));
        }

        return $this->buildTreeArray($aComponents);
    }



    /**
     * Transform Tree List
     *
     * @param  array $treeList
     * @return array
     */
    private function transformTreeList($treeList)
    {
        $list = array();
        foreach ($treeList as $node) {
            $item = array(
                "id" => $node["id"],
                "title" => $node["title"],
                "lvl" => $node["lvl"],
                "isActive" => $node["isActive"],
                "createdAt" => $node["createdAt"],
                "updatedAt" => $node["updatedAt"],
                "routerName" => $node["routerName"],
                "parameters" => $node["parameters"],
            );
            array_push($list, $item);
            if(!empty($node["__children"])) {
                $children = $this->transformTreeList($node["__children"]);
                $list = array_merge($list, $children);
            }
        }

        return $list;
    }
}
