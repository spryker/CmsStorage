<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Country\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Country\CountryDependencyProvider;
use Spryker\Zed\Country\Communication\Table\CountryTable;

/**
 * @method \Spryker\Zed\Country\CountryConfig getConfig()
 * @method \Spryker\Zed\Country\Persistence\CountryQueryContainer getQueryContainer()
 */
class CountryCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @return \Spryker\Zed\Country\Communication\Table\CountryTable
     */
    public function createCountryTable()
    {
        $countryQuery = $this->getQueryContainer()->queryCountries();

        return new CountryTable($countryQuery);
    }

    /**
     * @return \Spryker\Zed\User\Persistence\UserQueryContainer
     */
    protected function getUserQueryContainer()
    {
        return $this->getProvidedDependency(CountryDependencyProvider::QUERY_CONTAINER_USER);
    }

}