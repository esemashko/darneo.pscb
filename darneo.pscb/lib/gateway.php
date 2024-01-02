<?

namespace Darneo\PSCB;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Web\Json;
use Bitrix\Sale\BasketItem;
use Bitrix\Sale\Payment;
use Bitrix\Sale\PaymentCollection;
use Bitrix\Sale\Shipment;
use Darneo\PSCB\Helper\Constant as HelperConstant;
use Darneo\PSCB\Helper\Log as HelperLog;
use Darneo\PSCB\Helper\Tax as HelperTax;

class Gateway
{
    private Payment $payment;
    private array $options;

    public function __construct(Payment $payment, array $options)
    {
        $this->payment = $payment;
        $this->options = $options;
    }

    public function getParams(): array
    {
        $merchantId = $this->options['PSCB_MERCHANT_ID'] ?: '';
        $merchantKey = $this->options['PSCB_MERCHANT_KEY'] ?: '';
        $message = $this->getMessage();
        $messageText = Json::encode($message);

        $url = $this->options['PSCB_MERCHANT_TEST'] === 'Y' ? HelperConstant::TEST_PAY_URL : HelperConstant::WORK_PAY_URL;

        $params = [
            'url' => $url,
            'marketplace' => $merchantId,
            'message' => base64_encode($messageText),
            'signature' => hash('sha256', $messageText . $merchantKey)
        ];

        HelperLog::set('PaymentMessage', $message);
        HelperLog::set('PaymentParams', $params);

        return $params;
    }

    private function getMessage(): array
    {
        $nonce = sha1(time() . $this->payment->getField('ID'));
        $amount = $this->options['PSCB_ORDER_AMOUNT'] ?: 0;
        $paymentId = sprintf('%04d', $this->payment->getField('ID'));
        $showOrderId = $this->options['PSCB_ORDER_ID'] ?: $this->payment->getField('ACCOUNT_NUMBER');
        $paymentMethod = $this->options['PSCB_MERCHANT_METHOD'] ?: '';
        $customerComment = $this->options['PSCB_ORDER_DESCRIPTION'] ?: '';
        $customerEmail = $this->options['PSCB_ORDER_EMAIL'] ?: '';
        $customerPhone = $this->options['PSCB_ORDER_PHONE'] ?: '';
        $displayLanguage = $this->options['PSCB_LANG'] ?: 'ru';

        $isDebug = Option::get('darneo.pscb', 'darneo_pscb_is_log') === 'Y';
        $isHold = $this->options['PSCB_MERCHANT_HOLD'] === 'Y';

        $successUrl = $this->options['PSCB_RETURN_URL'] ?: '';
        $failUrl = $this->options['PSCB_FAIL_URL'] ?: '';
        $isReceipt = $this->options['PSCB_OFD_ACTIVE'] === 'Y';

        $params = [
            'nonce' => $nonce,
            'amount' => $amount,
            'orderId' => $paymentId,
            'showOrderId' => $showOrderId,
            'details' => $this->getDetails(),
            'paymentMethod' => $paymentMethod,
            'customerComment' => $this->getOrderDescription($customerComment),
            'customerEmail' => $customerEmail,
            'customerPhone' => $customerPhone ? $this->getPhoneValue($customerPhone) : '',
            'successUrl' => $successUrl,
            'failUrl' => $failUrl,
            'displayLanguage' => $displayLanguage,
            'data' => [
                'debug' => $isDebug,
                'hold' => $isHold
            ]
        ];

        if ($isReceipt) {
            $params['data']['fdReceipt'] = $this->getReceipt();
        }

        return $params;
    }

    private function getDetails(): string
    {
        $detail = '';

        /** @var PaymentCollection $collection */
        $collection = $this->payment->getCollection();
        $order = $collection->getOrder();
        $basket = $order->getBasket();
        if (!$basket) {
            return $detail;
        }

        $text = [];
        foreach ($basket as $basketItem) {
            $text[] = $basketItem->getField('NAME') . ' x' . $basketItem->getQuantity();
        }

        $collection = $order->getShipmentCollection();
        /** @var Shipment $shipment */
        foreach ($collection as $shipment) {
            if ($shipment->getPrice() > 0 && !$shipment->isSystem()) {
                $text[] = $shipment->getDeliveryName();
            }
        }

        $detail = implode(', ', $text);
        $detail = mb_substr($detail, 0, 2048);

        return $detail;
    }

    private function getPhoneValue(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);
        if ($phone[0] === '7') {
            $phone = '+' . $phone;
        }
        if ($phone[0] === '8') {
            $phone[0] = '7';
            $phone = '+' . $phone;
        }

        return $phone;
    }

    private function getReceipt(): array
    {
        $email = $this->options['PSCB_OFD_EMAIL'] ?: '';
        $tax = $this->options['PSCB_OFD_TAX'] ?: '';
        $itemTypePayment = $this->options['PSCB_OFD_TYPE_PAYMENT'] ?: '';
        $itemTypeItem = $this->options['PSCB_OFD_TYPE_SERVICE'] ?: '';
        $itemTypeDelivery = $this->options['PSCB_OFD_TYPE_DELIVERY'] ?: '';
        $taxItem = $this->options['PSCB_OFD_TAX_ITEM'] ?: HelperTax::NONE;
        $taxDelivery = $this->options['PSCB_OFD_TAX_DELIVERY'] ?: HelperTax::NONE;

        $receipt = [
            'companyEmail' => $email,
            'items' => []
        ];

        if ($tax) {
            $receipt['taxSystem'] = $tax;
        }

        /** @var PaymentCollection $collection */
        $collection = $this->payment->getCollection();
        $order = $collection->getOrder();
        $basket = $order->getBasket();
        if (!$basket) {
            return $receipt;
        }

        $items = [];
        /** @var BasketItem $basketItem */
        foreach ($basket as $basketItem) {
            $items[] = [
                'text' => mb_substr($basketItem->getField('NAME'), 0, 64),
                'price' => $basketItem->getPrice(),
                'quantity' => $basketItem->getQuantity(),
                'amount' => $basketItem->getFinalPrice(),
                'tax' => $taxItem,
                'type' => $itemTypePayment,
                'object' => $itemTypeItem,
                'unit' => $basketItem->getField('MEASURE_NAME'),
            ];
        }

        $collection = $order->getShipmentCollection();
        /** @var Shipment $shipment */
        foreach ($collection as $shipment) {
            if ($shipment->getPrice() > 0 && !$shipment->isSystem()) {
                $items[] = [
                    'text' => mb_substr($shipment->getDeliveryName(), 0, 64),
                    'price' => $shipment->getPrice(),
                    'quantity' => 1,
                    'amount' => $shipment->getPrice(),
                    'tax' => $taxDelivery,
                    'type' => $itemTypePayment,
                    'object' => $itemTypeDelivery
                ];
            }
        }

        return $items;
    }

    protected function getOrderDescription(string $text = ''): string
    {
        /** @var PaymentCollection $collection */
        $collection = $this->payment->getCollection();
        $order = $collection->getOrder();
        $userEmail = $order->getPropertyCollection()->getUserEmail();

        $description = str_replace(
            [
                '#PAYMENT_NUMBER#',
                '#ORDER_NUMBER#',
                '#PAYMENT_ID#',
                '#ORDER_ID#',
                '#USER_EMAIL#'
            ],
            [
                $this->payment->getField('ACCOUNT_NUMBER'),
                $order->getField('ACCOUNT_NUMBER'),
                $this->payment->getId(),
                $order->getId(),
                ($userEmail) ? $userEmail->getValue() : ''
            ],
            $text
        );

        return $description ?: '';
    }
}