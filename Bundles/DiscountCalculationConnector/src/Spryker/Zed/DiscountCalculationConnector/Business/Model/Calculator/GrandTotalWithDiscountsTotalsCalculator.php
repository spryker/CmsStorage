<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\DiscountCalculationConnector\Business\Model\Calculator;

use Generated\Shared\Transfer\TotalsTransfer;
use Spryker\Zed\Calculation\Business\Model\CalculableInterface;
use Spryker\Zed\Calculation\Dependency\Plugin\TotalsCalculatorPluginInterface;
use Spryker\Zed\DiscountCalculationConnector\Dependency\Facade\DiscountCalculationToCalculationInterface;

class GrandTotalWithDiscountsTotalsCalculator implements TotalsCalculatorPluginInterface
{

    /**
     * @var \Spryker\Zed\Calculation\Business\Model\Calculator\SubtotalTotalsCalculatorInterface
     */
    protected $grandTotalsCalculator;

    /**
     * @var \Spryker\Zed\DiscountCalculationConnector\Business\Model\Calculator\DiscountTotalsCalculatorInterface
     */
    protected $discountTotalsCalculator;

    /**
     * @param \Spryker\Zed\DiscountCalculationConnector\Dependency\Facade\DiscountCalculationToCalculationInterface $grandTotalsCalculator
     * @param \Spryker\Zed\DiscountCalculationConnector\Business\Model\Calculator\DiscountTotalsCalculatorInterface $discountTotalsCalculator
     */
    public function __construct(
        DiscountCalculationToCalculationInterface $grandTotalsCalculator,
        DiscountTotalsCalculatorInterface $discountTotalsCalculator
    ) {
        $this->grandTotalsCalculator = $grandTotalsCalculator;
        $this->discountTotalsCalculator = $discountTotalsCalculator;
    }

    /**
     * @param \Generated\Shared\Transfer\TotalsTransfer $totalsTransfer
     * @param \Spryker\Zed\Calculation\Business\Model\CalculableInterface $container
     * @param $items
     *
     * @return void
     */
    public function recalculateTotals(
        TotalsTransfer $totalsTransfer,
        CalculableInterface $container,
        $items
    ) {
        $grandTotal = $this->calculateGrandTotal($totalsTransfer, $container, $items);
        $grandTotal -= $this->getDiscount($totalsTransfer, $container, $items);
        $grandTotal = $this->adjustGrandTotalAmount($grandTotal);

        $totalsTransfer->setGrandTotalWithDiscounts($grandTotal);
    }

    /**
     * @param \Generated\Shared\Transfer\TotalsTransfer $totalsTransfer
     * @param \Spryker\Zed\Calculation\Business\Model\CalculableInterface $calculableContainer
     * @param $calculableItems
     *
     * @return int
     */
    protected function calculateGrandTotal(
        TotalsTransfer $totalsTransfer,
        CalculableInterface $calculableContainer,
        $calculableItems
    ) {
        $this->grandTotalsCalculator->recalculateGrandTotalTotals(
            $totalsTransfer,
            $calculableContainer,
            $calculableItems
        );

        return $totalsTransfer->getGrandTotal();
    }

    /**
     * @param \Generated\Shared\Transfer\TotalsTransfer $totalsTransfer
     * @param \Spryker\Zed\Calculation\Business\Model\CalculableInterface $calculableContainer
     * @param $calculableItems
     *
     * @return int
     */
    protected function getDiscount(
        TotalsTransfer $totalsTransfer,
        CalculableInterface $calculableContainer,
        $calculableItems
    ) {
        if ($totalsTransfer->getDiscount()->getTotalAmount() > 0) {
            return $totalsTransfer->getDiscount()->getTotalAmount();
        } else {
            return $this->discountTotalsCalculator->calculateDiscount($calculableContainer, $calculableItems);
        }
    }

    /**
     * @param int $grandTotal
     *
     * @return int
     */
    protected function adjustGrandTotalAmount($grandTotal)
    {
        if ($grandTotal < 0) {
            $grandTotal = 0;
        }

        return $grandTotal;
    }

}