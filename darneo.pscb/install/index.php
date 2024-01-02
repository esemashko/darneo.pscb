<?

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

IncludeModuleLangFile(__FILE__);
Loc::loadMessages(__FILE__);

class darneo_pscb extends CModule
{
    public $MODULE_ID = 'darneo.pscb';
    public $MODULE_NAME;

    private $MODULE_PATH;
    private $PAYMENT_HANDLER_PATH;

    public function __construct()
    {
        include __DIR__ . '/version.php';

        $this->MODULE_NAME = Loc::getMessage('DARNEO_PSCB_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('DARNEO_PSCB_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('DARNEO_PSCB_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('DARNEO_PSCB_PARTNER_URI');

        $this->MODULE_GROUP_RIGHTS = 'Y';

        if ($arModuleVersion !== null) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $ps_dir_path = strlen(COption::GetOptionString('sale', 'path2user_ps_files')) > 3 ? COption::GetOptionString(
            'sale',
            'path2user_ps_files'
        ) : '/bitrix/php_interface/include/sale_payment/';
        $this->PAYMENT_HANDLER_PATH = $_SERVER['DOCUMENT_ROOT'] . $ps_dir_path . str_replace(
                '.',
                '_',
                $this->MODULE_ID
            ) . '/';

        $this->MODULE_PATH = $this->GetPath();
    }

    public function GetPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot) {
            return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
        }

        return dirname(__DIR__);
    }

    public function DoInstall()
    {
        RegisterModule('darneo.pscb');
        $this->InstallDB();
        $this->InstallFiles();
        $this->InstallTasks();
        $this->InstallEvents();
    }

    public function InstallDB()
    {
        if (!Loader::includeModule('darneo.pscb')) {
            return false;
        }

        Option::set('darneo.pscb', 'darneo_pscb_is_log', 'Y');

        return true;
    }

    public function InstallFiles()
    {
        CopyDirFiles($this->MODULE_PATH . '/install/setup/handler_include', $this->PAYMENT_HANDLER_PATH, true, true);
        CopyDirFiles(
            $this->MODULE_PATH . '/install/setup/images/logo',
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/images/sale/sale_payments/'
        );
        $this->changeFiles(new DirectoryIterator($this->PAYMENT_HANDLER_PATH));
        $this->changeFiles(new DirectoryIterator($this->PAYMENT_HANDLER_PATH . 'template/'));

        return true;
    }

    private function changeFiles($files): void
    {
        foreach ($files as $file) {
            if ($file->isDot() === false) {
                $path_to_file = $file->getPathname();
                $file_contents = file_get_contents($path_to_file);
                $file_contents = str_replace('{module_path}', $this->MODULE_ID, $file_contents);
                file_put_contents($path_to_file, $file_contents);
            }
        }
    }

    public function DoUninstall()
    {
        global $APPLICATION;

        $this->UnInstallDB();
        $this->UnInstallFiles();
        $this->UnInstallTasks();
        $this->UnInstallEvents();

        UnRegisterModule('darneo.pscb');

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('DARNEO_PSCB_UNINSTALL_TITLE'),
            $this->GetPath() . '/install/unstep.php'
        );
    }

    public function UnInstallDB()
    {
        if (!Loader::includeModule('darneo.pscb')) {
            return false;
        }

        CAgent::RemoveModuleAgents('darneo.pscb');

        return true;
    }

    public function UnInstallFiles()
    {
        $ps_dir_path = strlen(COption::GetOptionString('sale', 'path2user_ps_files')) > 3 ? COption::GetOptionString(
            'sale',
            'path2user_ps_files'
        ) : '/bitrix/php_interface/include/sale_payment/';
        DeleteDirFilesEx($ps_dir_path . str_replace('.', '_', $this->MODULE_ID));

        return true;
    }
}
