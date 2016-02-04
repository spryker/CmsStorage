<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Payone\Communication\Plugin\Checkout;

use Spryker\Zed\Checkout\Dependency\Plugin\CheckoutOrderHydrationInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\CheckoutRequestTransfer;

/**
 * @method \Spryker\Zed\Payone\Business\PayoneCommunicationFactory getFactory()
 * @method \Spryker\Zed\Payone\Business\PayoneFacade getFacade()
 */
class CheckoutOrderHydrationPlugin extends AbstractPlugin implements CheckoutOrderHydrationInterface
{

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\CheckoutRequestTransfer $checkoutRequest
     *
     * @return void
     */
    public function hydrateOrder(OrderTransfer $orderTransfer, CheckoutRequestTransfer $checkoutRequest)
    {
        $orderTransfer->setPayonePayment($checkoutRequest->getPayonePayment());
    }

}