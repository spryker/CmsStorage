<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Glossary\Dependency\Facade;

interface GlossaryToLocaleInterface
{

    /**
     * @param string $localeName
     *
     * @throws \Spryker\Zed\Locale\Business\Exception\MissingLocaleException
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getLocale($localeName);

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getCurrentLocale();

    /**
     * @return array
     */
    public function getAvailableLocales();

    /**
     * @param string $localeName
     *
     * @throws \Spryker\Zed\Locale\Business\Exception\LocaleExistsException
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function createLocale($localeName);

}