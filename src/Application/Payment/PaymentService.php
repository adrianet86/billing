<?php

namespace App\Application\Payment;


use App\Domain\Billing\BillingBlockedException;
use App\Domain\Billing\BillingNotFoundException;
use App\Domain\Billing\BillingPaidException;
use App\Domain\Billing\BillingRepository;
use App\Domain\Log\LogAdapter;
use App\Domain\Log\LogAdapterException;
use App\Domain\Payment\PaymentDeclinedException;
use App\Domain\Payment\PaymentMethod;

class PaymentService
{
    const LOG_LEVEL_INFO = 'INFO';
    const LOG_LEVEL_ERROR = 'ERROR';

    private $paymentMethod;
    private $billingRepository;
    private $logAdapter;

    public function __construct(
        PaymentMethod $paymentMethod,
        BillingRepository $billingRepository,
        LogAdapter $logAdapter
    )
    {
        $this->paymentMethod = $paymentMethod;
        $this->billingRepository = $billingRepository;
        $this->logAdapter = $logAdapter;
    }

    /**
     * @param PaymentRequest $paymentRequest
     * @throws BillingNotFoundException
     * @throws PaymentDeclinedException
     * @throws BillingBlockedException
     * @throws BillingPaidException
     * @throws \Exception
     */
    public function execute(PaymentRequest $paymentRequest)
    {
        try {
            $this->log(self::LOG_LEVEL_INFO, 'START PAYMENT PROCESS BILLING: ' . $paymentRequest->billingId());

            $billing = $this->billingRepository->byId($paymentRequest->billingId());

            $this->log(self::LOG_LEVEL_INFO, 'BLOCK BILLING: ' . $paymentRequest->billingId());
            $billing->block();

            $this->log(
                'INFO',
                'PAYING BILLING: ' . $paymentRequest->billingId()
                . ' METHOD: ' . get_class($this->paymentMethod)
                . ' PAYMENT DETAILS: ' . json_encode($paymentRequest->paymentDetails())
            );
            $paymentDetails = $this->paymentMethod->payBilling($billing, $paymentRequest->paymentDetails());

            $this->log(
                'INFO',
                'PAYMENT COMPLETED: ' . $paymentRequest->billingId()
                . ' REFERENCE: ' . $paymentDetails->id()
            );

            $billing->setPaymentDetails($paymentDetails);

            $this->log(self::LOG_LEVEL_INFO, 'END PAYMENT PROCESS BILLING: ' . $paymentRequest->billingId());

        } catch (LogAdapterException $exception) {

            $this->log(self::LOG_LEVEL_ERROR, $exception->getMessage(), get_class($exception));

            throw $exception;

        } catch (BillingNotFoundException $exception) {

            $this->log(self::LOG_LEVEL_ERROR, $exception->getMessage(), get_class($exception));

            throw $exception;

        } catch (\Exception $exception) {

            $billing->unblock();

            $this->log(self::LOG_LEVEL_ERROR, $exception->getMessage(), get_class($exception));

            throw $exception;
        }
    }

    /**
     * @param $level
     * @param $message
     * @param null $class
     * @throws LogAdapterException
     */
    private function log($level, $message, $class = null)
    {
        $date = date('Y-m-d H:i:s');
        $message = "[$date] | [$level] - $message | $class";
        $this->logAdapter->log($message);
    }
}