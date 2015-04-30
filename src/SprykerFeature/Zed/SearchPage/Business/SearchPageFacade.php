<?php

namespace SprykerFeature\Zed\SearchPage\Business;

use SprykerEngine\Shared\Kernel\Messenger\MessengerInterface;
use SprykerEngine\Zed\Kernel\Business\AbstractFacade;
use SprykerFeature\Shared\SearchPage\Dependency\PageElementInterface;

/**
 * @method SearchPageDependencyContainer getDependencyContainer()
 */
class SearchPageFacade extends AbstractFacade
{

    /**
     * @param PageElementInterface $pageElement
     *
     * @return int
     */
    public function createPageElement(PageElementInterface $pageElement)
    {
        return $this->getDependencyContainer()
            ->createPageElementWriter()
            ->createPageElement($pageElement)
        ;
    }

    /**
     * @param PageElementInterface $pageElement
     *
     * @return int
     */
    public function updatePageElement(PageElementInterface $pageElement)
    {
        return $this->getDependencyContainer()
            ->createPageElementWriter()
            ->createPageElement($pageElement)
        ;
    }

    /**
     * @param PageElementInterface $pageElement
     *
     * @return int
     */
    public function deletePageElement(PageElementInterface $pageElement)
    {
        return $this->getDependencyContainer()
            ->createPageElementWriter()
            ->createPageElement($pageElement)
        ;
    }

    /**
     * @param int $idPageElement
     * @param bool $isElementActive
     *
     * @return bool
     */
    public function switchActiveState($idPageElement, $isElementActive)
    {
        return $this->getDependencyContainer()
            ->createPageElementWriter()
            ->switchActiveState($idPageElement, $isElementActive)
        ;
    }

    /**
     * @param MessengerInterface $messenger
     */
    public function installDocumentAttributes(MessengerInterface $messenger)
    {
        $this->getDependencyContainer()
            ->getDocumentAttributeInstaller($messenger)
            ->install()
        ;
    }

    /**
     * @param MessengerInterface $messenger
     */
    public function installTemplates(MessengerInterface $messenger)
    {
        $this->getDependencyContainer()
            ->getTemplateInstaller($messenger)
            ->install()
        ;
    }
}
