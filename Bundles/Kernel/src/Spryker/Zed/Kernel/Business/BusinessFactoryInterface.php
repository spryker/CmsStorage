<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel\Business;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

interface BusinessFactoryInterface
{

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     */
    public function setContainer(Container $container);

    /**
     * @param \Spryker\Zed\Kernel\Persistence\AbstractQueryContainer $queryContainer
     */
    public function setQueryContainer(AbstractQueryContainer $queryContainer);

}