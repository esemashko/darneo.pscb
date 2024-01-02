<?

use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Darneo\PSCB\Helper\Log as HelperLog;

global $APPLICATION;

Loc::loadMessages(__FILE__);
Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/options.php');

$request = (HttpApplication::getInstance())->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request['mid'] !== '' ? $request['mid'] : $request['id']);
$moduleAccessLevel = $APPLICATION->GetGroupRight($module_id);
if ($moduleAccessLevel < 'W') {
    $APPLICATION->AuthForm(Loc::getMessage('ACCESS_DENIED'));
}

Loader::includeModule($module_id);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$usersGroups = ['' => '[---]'];
$response = CGroup::GetList(($by = 'id'), ($order = 'asc'));
while ($group = $response->Fetch()) {
    $usersGroups[$group['ID']] = $group['NAME'];
}

$site = [];
$rsSites = CSite::GetList($by = 'SORT', $order = 'ASC', ['ACTIVE' => 'Y']);
while ($row = $rsSites->Fetch()) {
    $site[$row['LID']] = $row['NAME'] . ' (' . $row['LID'] . ')';
}

$statuses = [];
$dbStatus = CSaleStatus::GetList(['SORT' => 'ASC'], ['LID' => LANGUAGE_ID], false, false, ['ID', 'NAME', 'SORT']);
while ($arStatus = $dbStatus->GetNext()) {
    $statuses[$arStatus['ID']] = '[' . $arStatus['ID'] . '] ' . $arStatus['NAME'];
}

$tabs = [
    [
        'DIV' => 'settings',
        'TAB' => Loc::getMessage('DARNEO_PSCB_MENU_TAB_MODULE'),
        'TITLE' => Loc::getMessage('DARNEO_PSCB_MENU_TAB_MODULE_TITLE'),
        'OPTIONS' => [
            Loc::getMessage('DARNEO_PSCB_MENU_TAB_MODULE_OPTIONS_MAIN'),
            [
                'darneo_pscb_is_log',
                Loc::getMessage('DARNEO_PSCB_MENU_TAB_MODULE_OPTIONS_IS_LOG', ['#SIZE#' => HelperLog::getSize()]),
                '',
                [
                    'checkbox'
                ]
            ],
            [
                'darneo_pscb_change_status',
                Loc::getMessage('DARNEO_PSCB_MENU_TAB_MODULE_OPTIONS_STATUS_INFO'),
                '',
                [
                    'selectbox',
                    $statuses
                ]
            ],
        ]
    ]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_REQUEST['save']) > 0 && check_bitrix_sessid()) {
    foreach ($tabs as $tab) {
        array_map(
            static function ($value) {
            },
            $tab['OPTIONS']
        );
        __AdmSettingsSaveOptions($module_id, $tab['OPTIONS']);
    }

    LocalRedirect(
        $APPLICATION->GetCurPage() . '?lang=' . LANGUAGE_ID . '&mid_menu=1&mid=' . urlencode($module_id) .
        '&tabControl_active_tab=' . urlencode($_REQUEST['tabControl_active_tab']) . '&sid=' . urlencode($siteId)
    );
}

$tabControl = new CAdminTabControl('tabControl', $tabs);
?>
<form method='post' action='' name='main_options'>
    <?
    $tabControl->Begin();

    foreach ($tabs as $tab) {
        $tabControl->BeginNextTab();
        if ($tab['DIV'] === 'access') {
            require_once($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/admin/group_rights.php');
        } else {
            __AdmSettingsDrawList($module_id, $tab['OPTIONS']);
        }
    }

    $tabControl->Buttons(['btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false]); ?>

    <?= bitrix_sessid_post() ?>
    <?
    $tabControl->End(); ?>
</form>

