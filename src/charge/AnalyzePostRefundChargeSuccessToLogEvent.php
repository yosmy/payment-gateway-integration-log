<?php

namespace Yosmy\Payment;

use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.post_refund_charge_success',
 *     ]
 * })
 */
class AnalyzePostRefundChargeSuccessToLogEvent implements AnalyzePostRefundChargeSuccess
{
    /**
     * @var Yosmy\LogEvent
     */
    private $logEvent;

    /**
     * @param Yosmy\LogEvent $logEvent
     */
    public function __construct(
        Yosmy\LogEvent $logEvent
    ) {
        $this->logEvent = $logEvent;
    }

    /**
     * {@inheritDoc}
     */
    public function analyze(
        Charge $charge
    ) {
        $this->logEvent->log(
            [
                'yosmy.payment.refund_charge_success',
                'success'
            ],
            [
                'user' => $charge->getUser(),
                'card' => $charge->getCard(),
                'charge' => $charge->getId(),
            ],
            []
        );
    }
}