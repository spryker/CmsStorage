<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel\ClassResolver\Config;

use Spryker\Shared\Config;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Zed\Kernel\ClassResolver\ClassInfo;
use Spryker\Shared\Kernel\Exception\Backtrace;

class BundleConfigNotFoundException extends \Exception
{

    /**
     * @param \Spryker\Zed\Kernel\ClassResolver\ClassInfo $callerClassInfo
     */
    public function __construct(ClassInfo $callerClassInfo)
    {
        parent::__construct($this->buildMessage($callerClassInfo));
    }

    /**
     * @param \Spryker\Zed\Kernel\ClassResolver\ClassInfo $callerClassInfo
     *
     * @return string
     */
    protected function buildMessage(ClassInfo $callerClassInfo)
    {
        $message = 'Spryker Kernel Exception' . PHP_EOL;
        $message .= sprintf(
            'Can not resolve %1$sConfig for your bundle "%1$s"',
            $callerClassInfo->getBundle()
        ) . PHP_EOL;

        $message .= 'You can fix this by adding the missing Config to your bundle.';

        $message .= sprintf(
            'E.g. %s\\Zed\\%2$s\\%2$sConfig',
            Config::getInstance()->get(KernelConstants::PROJECT_NAMESPACE),
            $callerClassInfo->getBundle()
        );

        $message .= new Backtrace();

        return $message;
    }

}