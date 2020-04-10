<?php

namespace Yosmy\Payment;

use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.post_execute_charge_fail',
 *     ]
 * })
 */
class AnalyzePostExecuteChargeFailToLogEvent implements AnalyzePostExecuteChargeFail
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
        Card $card,
        int $amount,
        Exception $exception
    ) {
        $this->logEvent->log(
            [
                'yosmy.payment.execute_charge_fail',
                'fail'
            ],
            [
                'user' => $card->getUser(),
                'card' => $card->getId(),
            ],
            [
                'exception' => $exception->jsonSerialize()
            ]
        );
    }
}