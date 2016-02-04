<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\StockSalesConnector\Dependency\Facade;

use Generated\Shared\Transfer\StockProductTransfer;

interface StockSalesConnectorToStockInterface
{

    /**
     * @param \Generated\Shared\Transfer\StockProductTransfer $transferStockProduct
     *
     * @return int
     */
    public function updateStockProduct(StockProductTransfer $transferStockProduct);

    /**
     * @param string $sku
     * @param int $decrementBy
     * @param string $stockType
     */
    public function decrementStockProduct($sku, $stockType, $decrementBy = 1);

    /**
     * @param string $sku
     * @param string $stockType
     * @param int $incrementBy
     */
    public function incrementStockProduct($sku, $stockType, $incrementBy = 1);

}