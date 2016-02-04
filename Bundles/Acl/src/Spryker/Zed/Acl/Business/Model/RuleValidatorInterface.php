<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Acl\Business\Model;

use Generated\Shared\Transfer\RuleTransfer;
use Generated\Shared\Transfer\RulesTransfer;

interface RuleValidatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RulesTransfer $rules
     *
     * @return mixed
     */
    public function setRules(RulesTransfer $rules);

    /**
     * @param \Generated\Shared\Transfer\RuleTransfer $rule
     *
     * @return mixed
     */
    public function addRule(RuleTransfer $rule);

    /**
     * @return array
     */
    public function getAllowedRules();

    /**
     * @return array
     */
    public function getDeniedRules();

    /**
     * @param \Generated\Shared\Transfer\RuleTransfer $rule
     * @param string $bundle
     * @param string $controller
     * @param string $action
     *
     * @return bool
     */
    public function assert(RuleTransfer $rule, $bundle, $controller, $action);

    /**
     * @param string $bundle
     * @param string $controller
     * @param string $action
     *
     * @return bool
     */
    public function isAccessible($bundle, $controller, $action);

}