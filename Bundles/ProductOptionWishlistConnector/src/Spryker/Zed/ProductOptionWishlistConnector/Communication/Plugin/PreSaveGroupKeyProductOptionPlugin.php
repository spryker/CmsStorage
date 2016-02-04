<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\ProductOptionWishlistConnector\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Generated\Shared\Transfer\ProductOptionTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Spryker\Zed\Wishlist\Dependency\PreSavePluginInterface;

/**
 * @method \Spryker\Zed\ProductOptionWishlistConnector\Communication\ProductOptionWishlistConnectorCommunicationFactory getFactory()
 */
class PreSaveGroupKeyProductOptionPlugin extends AbstractPlugin implements PreSavePluginInterface
{

    /**
     * @param \ArrayObject $items
     *
     * @return void
     */
    public function trigger(\ArrayObject $items)
    {
        foreach ($items as $item) {
            $item->setGroupKey($this->buildGroupKey($item));
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $item
     *
     * @return string
     */
    protected function buildGroupKey(ItemTransfer $item)
    {
        $currentGroupKey = $item->getGroupKey();
        if (empty($item->getProductOptions())) {
            return $currentGroupKey;
        }

        $sortedProductOptions = $this->sortOptions((array) $item->getProductOptions());
        $optionGroupKey = $this->combineOptionParts($sortedProductOptions);

        if (empty($optionGroupKey)) {
            return $currentGroupKey;
        }

        return !empty($currentGroupKey) ? $currentGroupKey . '-' . $optionGroupKey : $optionGroupKey;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductOptionTransfer[] $options
     *
     * @return array
     */
    protected function sortOptions(array $options)
    {
        usort(
            $options,
            function (ProductOptionTransfer $productOptionLeft, ProductOptionTransfer $productOptionRight) {
                return ($productOptionLeft->getIdOptionValueUsage() < $productOptionRight->getIdOptionValueUsage()) ? -1 : 1;
            }
        );

        return $options;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductOptionTransfer[] $sortedProductOptions
     *
     * @return string
     */
    protected function combineOptionParts(array $sortedProductOptions)
    {
        $groupKeyPart = [];
        foreach ($sortedProductOptions as $option) {
            if (empty($option->getIdOptionValueUsage())) {
                continue;
            }
            $groupKeyPart[] = $option->getIdOptionValueUsage();
        }

        return implode('-', $groupKeyPart);
    }

}