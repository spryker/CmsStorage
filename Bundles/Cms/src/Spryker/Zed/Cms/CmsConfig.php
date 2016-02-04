<?php

/**
 * (c) Spryker Systems GmbH copyright protected.
 */

namespace Spryker\Zed\Cms;

use Spryker\Shared\Cms\CmsConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CmsConfig extends AbstractBundleConfig
{

    /**
     * @param string $templateRelativePath
     *
     * @return string
     */
    public function getTemplateRealPath($templateRelativePath)
    {
        $templateRelativePath = substr($templateRelativePath, 4);
        $physicalAddress = APPLICATION_ROOT_DIR . '/src/' . $this->get(CmsConstants::PROJECT_NAMESPACE) . '/Yves/Cms/Theme/' . $this->get(CmsConstants::YVES_THEME) . $templateRelativePath;

        return $physicalAddress;
    }

}