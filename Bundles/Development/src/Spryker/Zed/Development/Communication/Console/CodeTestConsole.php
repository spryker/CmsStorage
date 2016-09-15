<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Development\Communication\Console;

use Spryker\Zed\Console\Business\Model\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\Development\Business\DevelopmentFacade getFacade()
 */
class CodeTestConsole extends Console
{

    const COMMAND_NAME = 'code:test';
    const OPTION_BUNDLE = 'bundle';
    const OPTION_BUNDLE_ALL = 'all';
    const OPTION_INITIALIZE = 'initialize';
    const OPTION_GROUP = 'group';

    /**
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName(self::COMMAND_NAME)
            ->setHelp('<info>' . self::COMMAND_NAME . ' -h</info>')
            ->setDescription('Run codecept tests for project or core');

        $this->addOption(self::OPTION_BUNDLE, 'b', InputOption::VALUE_OPTIONAL, 'Name of core bundle to run tests for (or "all")');
        $this->addOption(self::OPTION_GROUP, 'g', InputOption::VALUE_OPTIONAL, 'Groups of tests to be executed (multiple values allowed, comma separated)');
        $this->addOption(self::OPTION_INITIALIZE, 'i', InputOption::VALUE_NONE, 'Initialize test suite by (re)generating required test classes');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $bundle = $this->input->getOption(self::OPTION_BUNDLE);

        $message = 'Run codecept tests for project level';
        if ($bundle) {
            $message = 'Run codecept tests for ' . $bundle . ' bundle';
        }
        $this->info($message);

        $initialize = $this->input->getOption(self::OPTION_INITIALIZE);
        if (!$initialize) {
            $this->warning('Make sure you ran `codecept build` already.');
        }

        $this->getFacade()->runTest($bundle, $this->input->getOptions());
    }

}
