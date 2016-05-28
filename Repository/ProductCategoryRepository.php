<?php

namespace TNQSoft\AdminBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\AdminBundle\Service\PaginatorService;
use TNQSoft\AdminBundle\Entity\ProductCategory;

/**
 * Class ProductCategoryRepository
 *
 * @package TNQSoft\AdminBundle\Repository
 */
class ProductCategoryRepository extends BaseNestedTreeRepository
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
        $dql = $this->getRepository()->createQueryBuilder('pc')
                ->orderBy('pc.createdAt', 'DESC')
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
        $treeList = $this->childrenHierarchy();

        if(true === $transform) {
            return $this->transformTreeList($treeList);
        }

        return $treeList;
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
                "slug" => $node["slug"],
                "lvl" => $node["lvl"],
                "webPath" => $this->getWebPath($node["picture"]),
                "isActive" => $node["isActive"],
                "createdAt" => $node["createdAt"],
                "updatedAt" => $node["updatedAt"],
            );
            array_push($list, $item);
            if(!empty($node["__children"])) {
                $children = $this->transformTreeList($node["__children"]);
                $list = array_merge($list, $children);
            }
        }

        return $list;
    }

    /**
     * @param $picture
     * @return null|string
     */
    private function getWebPath($picture)
    {
        $productCategory = new ProductCategory();

        return null === $picture
            ? null
            : $productCategory->getUploadDir().$picture;
    }
}
