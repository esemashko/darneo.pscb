<? if (!check_bitrix_sessid()) {
    return;
} ?>
<?= CAdminMessage::ShowNote(GetMessage('DARNEO_PSCB_MODULE_UNINSTALL_OK')) ?>
<form action='<? echo $APPLICATION->GetCurPage() ?>'>
    <input type='hidden' name='lang' value='<? echo LANG ?>'>
    <input type='submit' name='' value='<? echo GetMessage('MOD_BACK') ?>'>
    <form>
