<?

/**
 * @var array $params
 */

use Bitrix\Main\Localization\Loc;

IncludeModuleLangFile(__FILE__);
?>
<div style='margin-bottom: 40px'>
    <form method='post' action='<?= $params['url'] ?>' class='pscb-payform'>
        <input type='hidden' name='marketPlace' value='<?= $params['marketplace'] ?>'>
        <input type='hidden' name='message' value='<?= $params['message'] ?>'>
        <input type='hidden' name='signature' value='<?= $params['signature'] ?>'>
        <input type='submit' class='pscb-button' value='<?= Loc::getMessage('PSCB_TEMPLATE_BUTTON_BUY') ?>'>
    </form>
</div>
<style>
    .pscb-payform .pscb-button {
        display: inline-block;
        opacity: 0.7;
        color: rgba(77, 79, 83, 0.8);
        background-color: rgba(85, 237, 0, 0.8);
        width: auto;
        height: 60px;
        font-size: 16px;
        border: 0;
        border-radius: 5px;
        font-weight: bold;
        padding: 0 60px;
    }

    .pscb-payform input:hover {
        box-shadow: 0 0 1px 1px rgb(85, 237, 0);
        border: 1px solid #e3e3e3;
        outline: none;
    }

    .pscb-payform input:focus {
        box-shadow: 0 0 1px 1px rgb(85, 237, 0);
        border: 1px solid #e3e3e3;
        outline: none;
    }

    .pscb-payform input[type="submit"] {
        box-shadow: none;
        border: 0;
    }

    .pscb-payform input[type="submit"]:hover {
        background-image: -moz-linear-gradient(top, #55e300, #55cf00);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#55e300), to(#55cf00));
        background-image: -webkit-linear-gradient(top, #55e300, #55cf00);
        background-image: -o-linear-gradient(top, #55e300, #55cf00);
        background-image: linear-gradient(to bottom, #55e300, #55cf00);
        background-repeat: repeat-x;
    }
</style>
