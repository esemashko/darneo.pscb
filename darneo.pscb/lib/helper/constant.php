<?

namespace Darneo\PSCB\Helper;

define('LOG_FILE', realpath(dirname(__DIR__, 2)) . '/logs/pscb.log');

class Constant
{
    public const LOG_FILE = LOG_FILE;
    public const TEST_PAY_URL = 'https://oosdemo.pscb.ru/pay/';
    public const WORK_PAY_URL = 'https://oos.pscb.ru/pay/';
    public const CURRENCY = 'RUB';
}
