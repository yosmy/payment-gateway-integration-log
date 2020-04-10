<?php

namespace Yosmy\Payment;

use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.post_add_card_fail',
 *     ]
 * })
 */
class AnalyzePostAddCardFailToLogEvent implements AnalyzePostAddCardFail
{
    /**
     * @var Card\CalculateFingerprint
     */
    private $calculateFingerprint;

    /**
     * @var Yosmy\LogEvent
     */
    private $logEvent;

    /**
     * @param Card\CalculateFingerprint $calculateFingerprint
     * @param Yosmy\LogEvent            $logEvent
     */
    public function __construct(
        Card\CalculateFingerprint $calculateFingerprint,
        Yosmy\LogEvent $logEvent
    ) {
        $this->calculateFingerprint = $calculateFingerprint;
        $this->logEvent = $logEvent;
    }

    /**
     * {@inheritDoc}
     */
    public function analyze(
        Customer $customer,
        string $number,
        string $name,
        string $month,
        string $year,
        string $cvc,
        string $zip,
        Exception $exception
    ) {
        $fingerprint = $this->calculateFingerprint->calculate($number);

        $this->logEvent->log(
            [
                'yosmy.payment.add_card_fail',
                'fail'
            ],
            [
                'user' => $customer->getUser(),
                'fingerprint' => $fingerprint
            ],
            [
                'raw' => [
                    'number' => $number,
                    'name' => $name,
                    'month' => $month,
                    'year' => $year,
                    'cvc' => $cvc,
                    'zip' => $zip,
                ],
                'exception' => $exception->jsonSerialize()
            ]
        );
    }
}