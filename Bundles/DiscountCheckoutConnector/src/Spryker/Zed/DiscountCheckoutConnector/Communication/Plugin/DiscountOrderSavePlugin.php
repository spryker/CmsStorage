<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\DiscountCheckoutConnector\Communication\Plugin;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Checkout\Dependency\Plugin\CheckoutSaveOrderInterface;

/**
 * @method \Spryker\Zed\DiscountCheckoutConnector\Business\DiscountCheckoutConnectorFacade getFacade()
 * @method \Spryker\Zed\DiscountCheckoutConnector\Communication\DiscountCheckoutConnectorCommunicationFactory getFactory()
 */
class DiscountOrderSavePlugin extends AbstractPlugin implements CheckoutSaveOrderInterface
{

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function saveOrder(OrderTransfer $orderTransfer, CheckoutResponseTransfer $checkoutResponse)
    {
        $this->getFacade()->saveDiscounts($orderTransfer, $checkoutResponse);
    }

}