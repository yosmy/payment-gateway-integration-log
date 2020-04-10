<?php

namespace Yosmy\Payment;

use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.post_execute_charge_success',
 *     ]
 * })
 */
class AnalyzePostExecuteChargeSuccessToLogEvent implements AnalyzePostExecuteChargeSuccess
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
                'yosmy.payment.execute_charge_success',
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