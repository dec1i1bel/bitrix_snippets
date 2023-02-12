<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class DiscountGetComponent extends \CBitrixComponent
{
    public function executeComponent()
    {
        global $USER;
        try {
            if ($USER && $USER->IsAuthorized()) {
                $this->arResult['USER']['ID'] = $USER->GetID();
                $this->includeComponentTemplate();
            }
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}