<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Yves\Application\Plugin\Provider\ExceptionService;

use Symfony\Component\Debug\Exception\FlattenException;

interface ExceptionHandlerInterface
{

    /**
     * @param \Symfony\Component\Debug\Exception\FlattenException $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleException(FlattenException $exception);

}