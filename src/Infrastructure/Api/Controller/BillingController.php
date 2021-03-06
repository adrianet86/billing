<?php

namespace App\Infrastructure\Api\Controller;

use App\Application\Payment\PaymentRequest;
use App\Application\Payment\PaymentService;
use App\Application\Payment\PaymentWithPoliciesService;
use App\Domain\Billing\BillingBlockedException;
use App\Domain\Billing\BillingNotFoundException;
use App\Domain\Billing\BillingPaidException;
use App\Domain\Payment\PaymentDeclinedException;
use App\Domain\Payment\PaymentMethod;
use App\Domain\Policy\FraudPolicy;
use App\Domain\Policy\PolicyException;
use App\Infrastructure\External\Payment\CreditCardPaymentMethod;
use App\Infrastructure\External\Payment\PayPalPaymentMethod;
use App\Infrastructure\Repository\Billing\FakeBillingRepository;
use App\Infrastructure\Repository\Log\FakeLogAdapterRepository;

/**
 * @Route("/api/billing")
 *
 */
class BillingController
{
    private function getPolicyDetails($request): array
    {
        $policyDetails = [];
        $policies = [];

        if (isset($request['policy']) && isset($request['policy']['fraud'])) {
            $policyDetails = $request['policy'];
            $policies[] = new FraudPolicy();
        }

        return [$policies, $policyDetails];
    }

    /**
     * @param string $billingId
     * @param $request
     * @param PaymentMethod $paymentMethod
     * @return int
     */
    private function makePayment(string $billingId, $request, PaymentMethod $paymentMethod): int
    {
        try {
            $httpCode = 200;

            list($policies, $policyDetails) = $this->getPolicyDetails($request);

            $paymentService = new PaymentService(
                $paymentMethod,
                new FakeBillingRepository(),
                new FakeLogAdapterRepository()
            );

            $paymentWithPoliciesService = new PaymentWithPoliciesService(
                $paymentService,
                $policies
            );

            $paymentWithPoliciesService->execute(new PaymentRequest(
                $billingId,
                $request,
                $policyDetails
            ));

        } catch (BillingNotFoundException $exception) {
            $httpCode = 404;
        } catch (BillingBlockedException $exception) {
            $httpCode = 409;
        } catch (BillingPaidException $exception) {
            $httpCode = 412;
        } catch (PaymentDeclinedException $exception) {
            $httpCode = 403;
        } catch (PolicyException $exception) {
            $httpCode = 403;
        } catch (\Exception $exception) {
            $httpCode = 500;
        }

        return $httpCode;
    }

    /**
     * @param string $billingId
     * @param array $request
     * @return int
     * @Route("/{id}/payment/paypal")
     * @Method({"POST"})
     */
    public function paymentByPayPal(string $billingId, $request)
    {
        return $this->makePayment($billingId, $request['paypal'], new PayPalPaymentMethod());
    }

    /**
     * @param string $billingId
     * @param array $request
     * @return int
     * @Route("/{id}/payment/credit-card")
     * @Method({"POST"})
     */
    public function paymentByCreditCard(string $billingId, $request)
    {
        return $this->makePayment($billingId, $request['credit-card'], new CreditCardPaymentMethod());
    }

}
