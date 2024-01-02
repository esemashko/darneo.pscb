<?

namespace Darneo\PSCB\Helper;

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use CSalePaySystemAction;
use Darneo\PSCB\Helper\Log as HelperLog;

Loader::includeModule('sale');

class Encrypted
{
    private string $encrypted;
    private array $jsonRequest = [];

    public function __construct(string $encrypted)
    {
        $this->encrypted = $encrypted;
        $this->init();
    }

    private function init(): void
    {
        $merchantKey = $this->getMerchantKey();
        foreach ($merchantKey as $key) {
            $decrypted_request = $this->decrypt($key);
            $jsonRequest = Json::decode($decrypted_request);
            if (is_array($jsonRequest)) {
                $this->jsonRequest = $jsonRequest;
            }
        }
    }

    private function getMerchantKey(): array
    {
        $rows = [];
        $result = CSalePaySystemAction::getList([], ['ACTION_FILE' => 'darneo_pscb']);
        while ($row = $result->Fetch()) {
            $params = unserialize($row['PARAMS']);
            $rows[] = $params['PSCB_MERCHANT_KEY']['VALUE'] ?: '';
            HelperLog::set('SearchPayment', $row);
        }

        return $rows;
    }

    private function decrypt(string $merchantKey): string
    {
        $key_md5_binary = hash('md5', $merchantKey, true);
        $decrypted = openssl_decrypt($this->encrypted, 'AES-128-ECB', $key_md5_binary, OPENSSL_RAW_DATA);

        return $decrypted;
    }

    public function getRequestToArray(): array
    {
        return $this->jsonRequest;
    }
}

?>