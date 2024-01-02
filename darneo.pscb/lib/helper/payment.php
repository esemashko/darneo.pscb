<?

namespace Darneo\PSCB\Helper;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
use Bitrix\Sale\Order;
use Bitrix\Sale\PaymentCollection;
use CSaleStatus;
use Darneo\PSCB\Helper\Constant as HelperConstant;
use Darneo\PSCB\Helper\Log as HelperLog;

class Payment
{
    private array $data;
    private int $paymentId;
    private float $amount;
    private string $status;

    private int $orderId;

    /**
     * @param array $data = {orderId, showOrderId, paymentId, account, amount, state, type, marketPlace, paymentMethod, stateDate}
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->paymentId = $data['orderId'];
        $this->amount = (float)$data['amount'];
        $this->status = $data['state'];
        $this->orderId = $this->getOrderIdByPayment($data['orderId']);
    }

    private function getOrderIdByPayment(int $paymentId): int
    {
        $parameters = [
            'select' => ['ORDER_ID'],
            'filter' => [
                '=ID' => $paymentId,
            ]
        ];
        $result = PaymentCollection::getList($parameters);
        if ($row = $result->fetch()) {
            return $row['ORDER_ID'] ?: 0;
        }

        return 0;
    }

    public function init(): void
    {
        $order = Order::load($this->orderId);
        if (!$order) {
            return;
        }

        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->getItemById($this->paymentId);

        $sum = $payment->getSum();

        if ($this->amount === $sum) {
            $fields = [];
            switch ($this->status) {
                case 'end':
                    $fields['PAID'] = 'Y';
                    $payment->setPaid('Y');
                    $psStatus = Loc::getMessage('PSCB_HELPER_STATUS_END_TITLE');
                    $psStatusDescription = Loc::getMessage('PSCB_HELPER_STATUS_END_DESC');

                    $changeStatus = $this->getSettingChangeStatus();
                    $status = $this->getStatusId();
                    if ($changeStatus && in_array($changeStatus, $status, true)) {
                        $order->setField('STATUS_ID', $changeStatus);
                    }
                    break;
                case 'ref':
                    $fields['IS_RETURN'] = 'Y';
                    $psStatus = Loc::getMessage('PSCB_HELPER_STATUS_REF_TITLE');
                    $psStatusDescription = Loc::getMessage('PSCB_HELPER_STATUS_REF_DESC');
                    break;
                case 'exp':
                    $psStatus = Loc::getMessage('PSCB_HELPER_STATUS_EXP_TITLE');
                    $psStatusDescription = Loc::getMessage('PSCB_HELPER_STATUS_EXP_DESC');
                    break;
                case 'canceled':
                    $psStatus = Loc::getMessage('PSCB_HELPER_STATUS_CANCELED_TITLE');
                    $psStatusDescription = Loc::getMessage('PSCB_HELPER_STATUS_CANCELED_DESC');
                    break;
                case 'err':
                    $psStatus = Loc::getMessage('PSCB_HELPER_STATUS_ERROR_TITLE');
                    $psStatusDescription = Loc::getMessage('PSCB_HELPER_STATUS_ERROR_DESC');
                    break;
                default:
                    $psStatus = Loc::getMessage('PSCB_HELPER_STATUS_DEFAULT_TITLE');
                    $psStatusDescription = Loc::getMessage('PSCB_HELPER_STATUS_DEFAULT_DESC');
                    break;
            }

            $fields = array_merge($fields, [
                'PS_INVOICE_ID' => $this->data['paymentId'],
                'PS_STATUS' => 'Y',
                'PS_STATUS_CODE' => $this->data['state'],
                'PS_STATUS_DESCRIPTION' => $psStatus . ': ' . $psStatusDescription,
                'PS_STATUS_MESSAGE' => $this->data['paymentMethod'],
                'PS_SUM' => $this->data['amount'],
                'PS_CURRENCY' => HelperConstant::CURRENCY,
                'PS_RESPONSE_DATE' => new DateTime(),
                'EXTERNAL_PAYMENT' => 'Y',
                'ACCOUNT_NUMBER' => $this->data['paymentId']
            ]);

            HelperLog::set('Fields update field', $fields);

            $r = $payment->setFields($fields);
            if (!$r->isSuccess()) {
                HelperLog::set('Error update field', $r->getErrorMessages(), true);
            }
        }

        $order->save();
    }

    private function getSettingChangeStatus(): string
    {
        return Option::get('darneo.pscb', 'darneo_pscb_change_status') ?: '';
    }

    private function getStatusId(): array
    {
        $statuses = [];
        $dbStatus = CSaleStatus::GetList(
            ['SORT' => 'ASC'],
            ['LID' => LANGUAGE_ID],
            false,
            false,
            ['ID', 'NAME', 'SORT']
        );
        while ($arStatus = $dbStatus->GetNext()) {
            $statuses[] = $arStatus['ID'];
        }

        return $statuses;
    }
}
