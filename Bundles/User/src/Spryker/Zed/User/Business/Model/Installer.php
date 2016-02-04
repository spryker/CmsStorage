<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\User\Business\Model;

use Spryker\Zed\User\Persistence\UserQueryContainer;
use Spryker\Zed\User\UserConfig;

class Installer implements InstallerInterface
{

    /**
     * @var \Spryker\Zed\User\Persistence\UserQueryContainer
     */
    protected $queryContainer;

    /**
     * @var \Spryker\Zed\User\Business\Model\UserInterface
     */
    protected $user;

    /**
     * @var \Spryker\Zed\User\UserConfig
     */
    protected $settings;

    /**
     * @param \Spryker\Zed\User\Persistence\UserQueryContainer $queryContainer
     * @param \Spryker\Zed\User\Business\Model\UserInterface $user
     * @param \Spryker\Zed\User\UserConfig $settings
     */
    public function __construct(
        UserQueryContainer $queryContainer,
        UserInterface $user,
        UserConfig $settings
    ) {
        $this->queryContainer = $queryContainer;
        $this->user = $user;
        $this->settings = $settings;
    }

    /**
     * Main Installer Method
     *
     * @return void
     */
    public function install()
    {
        $this->addUsers($this->settings->getInstallerUsers());
    }

    /**
     * @return void
     */
    protected function addUsers(array $usersArray)
    {
        foreach ($usersArray as $user) {
            if (!$this->user->hasUserByUsername($user['username'])) {
                $this->user->addUser(
                    $user['firstName'],
                    $user['lastName'],
                    $user['username'],
                    $user['password']
                );
            }
        }
    }

}