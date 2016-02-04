<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Cart\Business\Operator;

use Generated\Shared\Transfer\ChangeTransfer;
use Spryker\Zed\Cart\Dependency\ItemExpanderPluginInterface;

interface OperatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\ChangeTransfer $cartChange
     *
     * @return \Generated\Shared\Transfer\CartTransfer
     */
    public function executeOperation(ChangeTransfer $cartChange);

    /**
     * @param \Spryker\Zed\Cart\Dependency\ItemExpanderPluginInterface $itemExpander
     */
    public function addItemExpanderPlugin(ItemExpanderPluginInterface $itemExpander);

}