<?

namespace Darneo\PSCB\Helper;

use Bitrix\Main\Config\Option;

class Log
{
    public static function set(string $title, array $log, bool $isError = false): void
    {
        if (self::isWrite()) {
            $fields = [
                'DATE' => date('Y-m-d H:i:s'),
                'TITLE' => $title,
                'STATUS' => $isError ? 'ERROR' : 'SUCCESS',
                'LOG' => $log,
            ];
            file_put_contents(Constant::LOG_FILE, print_r($fields, true), FILE_APPEND | LOCK_EX);
        }
    }

    public static function isWrite(): bool
    {
        return Option::get('darneo.pscb', 'darneo_pscb_is_log') === 'Y';
    }

    public static function getSize(): string
    {
        $bytes = 0;
        if (file_exists(Constant::LOG_FILE)) {
            $bytes = filesize(Constant::LOG_FILE);
        }

        return self::humanBytes($bytes);
    }

    public static function humanBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= 1024 ** $pow;

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
