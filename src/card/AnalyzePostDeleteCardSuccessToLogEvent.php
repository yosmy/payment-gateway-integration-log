<?php

namespace Yosmy\Payment;

use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.post_delete_card_success',
 *     ]
 * })
 */
class AnalyzePostDeleteCardSuccessToLogEvent implements AnalyzePostDeleteCardSuccess
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
        Card $card
    ) {
        $this->logEvent->log(
            [
                'yosmy.payment.delete_card_success',
                'success'
            ],
            [
                'user' => $card->getUser(),
                'card' => $card->getId()
            ],
            []
        );
    }
}