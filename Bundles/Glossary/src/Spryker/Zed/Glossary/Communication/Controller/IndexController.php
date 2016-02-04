<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Glossary\Communication\Controller;

use Spryker\Zed\Application\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method \Spryker\Zed\Glossary\Business\GlossaryFacade getFacade()
 * @method \Spryker\Zed\Glossary\Persistence\GlossaryQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Glossary\Communication\GlossaryCommunicationFactory getFactory()
 */
class IndexController extends AbstractController
{

    /**
     * @return array
     */
    public function indexAction()
    {
        $availableLocales = $this->getFactory()
            ->getEnabledLocales();

        $table = $this->getFactory()
            ->createTranslationTable($availableLocales);

        return $this->viewResponse([
            'locales' => $availableLocales,
            'glossaryTable' => $table->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction()
    {
        $availableLocales = $this->getFactory()
            ->getEnabledLocales();

        $table = $this->getFactory()
            ->createTranslationTable($availableLocales);

        return $this->jsonResponse($table->fetchData());
    }

}