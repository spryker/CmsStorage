<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */
namespace Spryker\Zed\Sales\Business\Model\Split;

interface ItemInterface
{

    /**
     * @param int $idSalesOrderItem
     * @param int $quantityToSplit
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ItemSplitResponseTransfer
     */
    public function split($idSalesOrderItem, $quantityToSplit);

}