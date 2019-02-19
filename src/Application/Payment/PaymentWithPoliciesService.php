<?php

namespace App\Application\Payment;


use App\Domain\Policy\Policy;

class PaymentWithPoliciesService
{
    private $policies;
    private $paymentService;

    public function __construct(PaymentService $paymentService, array $policies)
    {
        $this->paymentService = $paymentService;
        $this->policies = $policies;
    }

    /**
     * @param PaymentRequest $paymentRequest
     * @throws \App\Domain\Billing\BillingNotFoundException
     * @throws \App\Domain\Billing\BillingBlockedException
     * @throws \App\Domain\Billing\BillingPaidException
     * @throws \App\Domain\Payment\PaymentDeclinedException
     * @throws \Exception
     *
     */
    public function execute(PaymentRequest $paymentRequest)
    {
        $this->executePolicies($paymentRequest->policyDetails());

        return $this->paymentService->execute($paymentRequest);
    }

    /**
     * @param $policyDetails
     */
    private function executePolicies($policyDetails): void
    {
        if (!empty($this->policies)) {
            /* @var Policy $policy */
            foreach ($this->policies as $policy) {
                if ($policy instanceof Policy) {
                    $policy->execute($policyDetails);
                }
            }
        }
    }
}