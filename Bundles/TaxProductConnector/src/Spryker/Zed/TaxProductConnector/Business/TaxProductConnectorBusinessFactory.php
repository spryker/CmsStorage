<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\TaxProductConnector\Business;

use Spryker\Zed\TaxProductConnector\Business\Plugin\TaxChangeTouchPlugin;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\TaxProductConnector\TaxProductConnectorDependencyProvider;

/**
 * @method \Spryker\Zed\TaxProductConnector\TaxProductConnectorConfig getConfig()
 * @method \Spryker\Zed\TaxProductConnector\Persistence\TaxProductConnectorQueryContainer getQueryContainer()
 */
class TaxProductConnectorBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return \Spryker\Zed\Tax\Dependency\Plugin\TaxChangePluginInterface
     */
    public function createTaxChangeTouchPlugin()
    {
        return new TaxChangeTouchPlugin(
            $this->getProductFacade(),
            $this->getQueryContainer()
        );
    }

    /**
     * @return \Spryker\Zed\TaxProductConnector\Dependency\Facade\TaxProductConnectorToProductInterface
     */
    protected function getProductFacade()
    {
        return $this->getProvidedDependency(TaxProductConnectorDependencyProvider::FACADE_PRODUCT);
    }

}