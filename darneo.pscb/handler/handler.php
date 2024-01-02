<?php

namespace Sale\Handlers\PaySystem;

use Bitrix\Main\Loader;
use Bitrix\Main\Request;
use Bitrix\Sale\Payment;
use Bitrix\Sale\PaySystem;
use Bitrix\Sale\PaySystem\ServiceResult;
use Darneo\PSCB\Gateway;
use Darneo\PSCB\Helper\Encrypted as HelperEncrypted;
use Darneo\PSCB\Helper\Log as HelperLog;
use Darneo\PSCB\Helper\Payment as HelperPayment;

IncludeModuleLangFile(__FILE__);
Loader::includeModule('darneo.pscb');

class darneo_pscbHandler extends PaySystem\ServiceHandler implements PaySystem\IPrePayable
{
    public static function getIndicativeFields()
    {
        return ['PAYMENT' => 'PSCB'];
    }

    protected static function isMyResponseExtended(Request $request, $paySystemId): bool
    {
        return $request->get('PAYMENT') === 'PSCB';
    }

    public function initiatePay(Payment $payment, Request $request = null): ServiceResult
    {
        $options = [
            'PSCB_MERCHANT_ID' => $this->getBusinessValue($payment, 'PSCB_MERCHANT_ID'),
            'PSCB_MERCHANT_KEY' => $this->getBusinessValue($payment, 'PSCB_MERCHANT_KEY'),
            'PSCB_MERCHANT_TEST' => $this->getBusinessValue($payment, 'PSCB_MERCHANT_TEST'),
            'PSCB_MERCHANT_METHOD' => $this->getBusinessValue($payment, 'PSCB_MERCHANT_METHOD'),
            'PSCB_MERCHANT_HOLD' => $this->getBusinessValue($payment, 'PSCB_MERCHANT_HOLD'),
            'PSCB_RETURN_URL' => $this->getBusinessValue($payment, 'PSCB_RETURN_URL'),
            'PSCB_FAIL_URL' => $this->getBusinessValue($payment, 'PSCB_FAIL_URL'),
            'PSCB_LANG' => $this->getBusinessValue($payment, 'PSCB_LANG'),
            'PSCB_ORDER_ID' => $this->getBusinessValue($payment, 'PSCB_ORDER_ID'),
            'PSCB_ORDER_AMOUNT' => $this->getBusinessValue($payment, 'PSCB_ORDER_AMOUNT'),
            'PSCB_ORDER_EMAIL' => $this->getBusinessValue($payment, 'PSCB_ORDER_EMAIL'),
            'PSCB_ORDER_PHONE' => $this->getBusinessValue($payment, 'PSCB_ORDER_PHONE'),
            'PSCB_ORDER_DESCRIPTION' => $this->getBusinessValue($payment, 'PSCB_ORDER_DESCRIPTION'),
            'PSCB_OFD_ACTIVE' => $this->getBusinessValue($payment, 'PSCB_OFD_ACTIVE'),
            'PSCB_OFD_TAX' => $this->getBusinessValue($payment, 'PSCB_OFD_TAX'),
            'PSCB_OFD_EMAIL' => $this->getBusinessValue($payment, 'PSCB_OFD_EMAIL'),
            'PSCB_OFD_TYPE_PAYMENT' => $this->getBusinessValue($payment, 'PSCB_OFD_TYPE_PAYMENT'),
            'PSCB_OFD_TYPE_SERVICE' => $this->getBusinessValue($payment, 'PSCB_OFD_TYPE_SERVICE'),
            'PSCB_OFD_TYPE_DELIVERY' => $this->getBusinessValue($payment, 'PSCB_OFD_TYPE_DELIVERY'),
            'PSCB_OFD_TAX_ITEM' => $this->getBusinessValue($payment, 'PSCB_OFD_TAX_ITEM'),
            'PSCB_OFD_TAX_DELIVERY' => $this->getBusinessValue($payment, 'PSCB_OFD_TAX_DELIVERY'),
        ];

        $gateway = new Gateway($payment, $options);
        $params = $gateway->getParams();

        $this->setExtraParams($params);

        return $this->showTemplate($payment, 'payment');
    }

    public function getCurrencyList(): array
    {
        return ['RUB', 'EUR', 'USD', 'UAH', 'BYN'];
    }

    public function initPrePayment(Payment $payment = null, Request $request): bool
    {
        return true;
    }

    public function getProps(): array
    {
        return [];
    }

    public function payOrder($orderData = [])
    {
    }

    public function setOrderConfig($orderData = []): void
    {
    }

    public function basketButtonAction($orderData): void
    {
    }

    public function processRequest(Payment $payment, Request $request)
    {
        $result = new ServiceResult();

        return $result;
    }

    /**
     * Приходит массив всех платежей, поэтому вся обработка здесь.
     *
     * @param Request $request
     *
     * @return int
     */
    public function getPaymentIdFromRequest(Request $request): int
    {
        $encryptedRequest = file_get_contents('php://input');
        $requestArray = (new HelperEncrypted($encryptedRequest))->getRequestToArray();

        HelperLog::set('RequestArray', $requestArray);

        foreach ($requestArray['payments'] as $payment) {
            (new HelperPayment($payment))->init();
        }

        return 0;
    }
}
