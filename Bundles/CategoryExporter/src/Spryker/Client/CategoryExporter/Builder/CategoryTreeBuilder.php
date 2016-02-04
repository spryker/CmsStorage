<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Client\CategoryExporter\Builder;

use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\Collector\Code\KeyBuilder\KeyBuilderInterface;
use Spryker\Shared\CategoryExporter\Business\CategoryNodeKeyInterface;

class CategoryTreeBuilder
{

    const SUBTREE_DEPTH_KEY = 'depth';
    const SUBTREE_DEPTH = 3;

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    protected $kvReader;

    /**
     * @var \Spryker\Shared\Collector\Code\KeyBuilder\KeyBuilderInterface
     */
    protected $keyBuilder;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $kvReader
     * @param \Spryker\Shared\Collector\Code\KeyBuilder\KeyBuilderInterface $keyBuilder
     */
    public function __construct(StorageClientInterface $kvReader, KeyBuilderInterface $keyBuilder)
    {
        $this->kvReader = $kvReader;
        $this->keyBuilder = $keyBuilder;
    }

    /**
     * @param array $categoryNode
     * @param string $locale
     *
     * @return array
     */
    public function createTreeFromCategoryNode(array $categoryNode, $locale)
    {
        $parents = array_slice(array_reverse($categoryNode[CategoryNodeKeyInterface::PARENTS]), 0, self::SUBTREE_DEPTH);
        $subtree = [];
        $idCategoryCode = $categoryNode[CategoryNodeKeyInterface::NODE_ID];

        foreach ($parents as $parent) {
            $storageKey = $this->keyBuilder->generateKey(
                $parent[CategoryNodeKeyInterface::NODE_ID],
                $locale
            );
            $parentCategory = $this->kvReader->get($storageKey);

            if (isset($parentCategory[CategoryNodeKeyInterface::CHILDREN][$idCategoryCode])) {
                $parentCategory[CategoryNodeKeyInterface::CHILDREN][$idCategoryCode] = $categoryNode;
            }

            if (empty($subtree)) {
                $subtree = $parentCategory;
            }
            if ($parentCategory) {
                $parentCategory = $this->addCurrentSubtree($parentCategory, $subtree);
                $subtree = $parentCategory;
            }
        }

        if (empty($categoryNode[CategoryNodeKeyInterface::PARENTS]) || empty($subtree)) {
            $subtree = $categoryNode;
        }

        $subtree[self::SUBTREE_DEPTH_KEY] = self::SUBTREE_DEPTH;

        return $subtree;
    }

    /**
     * @param array $parentCategory
     * @param array $subtree
     *
     * @return array
     */
    protected function addCurrentSubtree(array $parentCategory, array $subtree)
    {
        foreach ($parentCategory[CategoryNodeKeyInterface::CHILDREN] as $key => $child) {
            if ($child[CategoryNodeKeyInterface::URL] === $subtree[CategoryNodeKeyInterface::URL]) {
                $parentCategory[CategoryNodeKeyInterface::CHILDREN][$key][CategoryNodeKeyInterface::CHILDREN] =
                    $subtree[CategoryNodeKeyInterface::CHILDREN];
            }
        }

        return $parentCategory;
    }

}