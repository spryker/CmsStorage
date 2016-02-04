<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Shipment\Communication\Controller;

use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Spryker\Zed\Application\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\Shipment\Communication\ShipmentCommunicationFactory getFactory()
 * @method \Spryker\Zed\Shipment\Business\ShipmentFacade getFacade()
 */
class MethodController extends AbstractController
{

    const ID_METHOD_PARAMETER = 'id-method';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $dataProvider = $this->getFactory()->createMethodFormDataProvider();
        $form = $this
            ->getFactory()
            ->createMethodForm(
                $dataProvider->getData(),
                $dataProvider->getOptions()
            )
            ->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $methodTransfer = new ShipmentMethodTransfer();
            $methodTransfer->fromArray($data, true);
            $this->getFacade()
                ->createMethod($methodTransfer);

            $this->addSuccessMessage('Shipment method ' . $methodTransfer->getName() . ' saved');

            return $this->redirectResponse('/shipment/');
        }

        return $this->viewResponse([
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $idMethod = $request->query->get(self::ID_METHOD_PARAMETER);

        if ($this->getFacade()->hasMethod($idMethod)) {
            $dataProvider = $this->getFactory()->createMethodFormDataProvider();
            $form = $this
                ->getFactory()
                ->createMethodForm(
                    $dataProvider->getData($idMethod),
                    $dataProvider->getOptions()
                )
                ->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $methodTransfer = new ShipmentMethodTransfer();
                $methodTransfer->fromArray($data, true);

                $this->getFacade()
                    ->updateMethod($methodTransfer);
                $this->addSuccessMessage('Shipment method ' . $methodTransfer->getName() . ' updated');

                return $this->redirectResponse('/shipment/');
            }

            return $this->viewResponse([
                'form' => $form->createView(),
            ]);
        }

        return $this->redirectResponse('/shipment/');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $idMethod = $request->query->get(self::ID_METHOD_PARAMETER);

        if ($this->getFacade()->hasMethod($idMethod)) {
            $this->getFacade()->deleteMethod($idMethod);
        }

        return $this->redirectResponse('/shipment/');
    }

}