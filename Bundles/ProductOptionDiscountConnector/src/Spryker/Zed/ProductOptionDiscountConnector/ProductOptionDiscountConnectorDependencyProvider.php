<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductOptionDiscountConnector;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductOptionDiscountConnector\Dependency\Facade\ProductOptionDiscountConnectorToTaxBridge;

class ProductOptionDiscountConnectorDependencyProvider extends AbstractBundleDependencyProvider
{

    const QUERY_CONTAINER_DISCOUNT = 'QUERY_CONTAINER_DISCOUNT';
    const FACADE_TAX = 'TAX_FACADE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[self::QUERY_CONTAINER_DISCOUNT] = function (Container $container) {
            return $container->getLocator()->discount()->queryContainer();
        };

        $container[self::FACADE_TAX] = function (Container $container) {
            return new ProductOptionDiscountConnectorToTaxBridge($container->getLocator()->tax()->facade());
        };

        return $container;
    }

}