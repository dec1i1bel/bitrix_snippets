<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class DiscountGetComponent extends \CBitrixComponent
{
    public function executeComponent()
    {
        global $USER;
        try {
            if ($USER && $USER->IsAuthorized()) {
                $this->arResult['USER']['ID'] = $USER->GetID();
            } else {
                $this->arResult['USER']['MESSAGE_NOT_AUTHORIZED'] = 'Пожалуйста авторизуйтесь для получения скидки';
            }
            $this->includeComponentTemplate();
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}