<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Localization\Loc as Loc;
use Bitrix\Main\Data\Cache;

class ItemsListComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        try {
            if (Loader::includeModule('iblock')) {

                if ($this->arParams['IBLOCK_ID'] > 0) {

                    $cache = Cache::createInstance();
                    $taggedCache = Application::getInstance()->getTaggedCache();

                    $cachePath = 'items_list';
                    $cacheTtl = 86400;
                    $cacheKey = 'items_list_key';

                    if ($cache->initCache($cacheTtl, $cacheKey, $cachePath)) {
                        $this->arResult = $cache->getVars();
                    } elseif ($cache->startDataCache()) {
                        $taggedCache->startTagCache($cachePath);
                        $order = [
                            $this->arParams['SORT_FIELD'] => $this->arParams['SORT_DIRECTION'],
                        ];

                        $filter = [
                            'IBLOCK_TYPE' => $this->arParams['IBLOCK_TYPE'],
                            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                            'ACTIVE' => 'Y',
                        ];

                        $select = [
                            'ID',
                            'NAME',
                            'DATE_ACTIVE_FROM',
                            'DETAIL_PAGE_URL',
                            'PREVIEW_TEXT',
                            'PREVIEW_PICTURE',
                        ];

                        $navStartParams = ($this->arParams['COUNT'] > 0) ?
                            ['nTopCount' => $this->arParams['COUNT']] :
                            false;

                        $rsItems = \CIBlockElement::GetList($order, $filter, false, $navStartParams, $select);

                        while ($item = $rsItems->GetNext()) {
                            $props = [
                                'ID' => $item['ID'],
                                'NAME' => $item['NAME'],
                                'DATE' => $item['DATE_ACTIVE_FROM'],
                                'URL' => $item['DETAIL_PAGE_URL'],
                                'TEXT' => $item['PREVIEW_TEXT'],
                            ];
                            if (!empty($item['PREVIEW_PICTURE'])) {
                                $props['PREVIEW_PICTURE'] = \CFile::GetPath($item['PREVIEW_PICTURE']);
                            }

                            $this->arResult['ITEMS'][] = $props;

                            $taggedCache->registerTag('iblock_'.$this->arParams['IBLOCK_ID'].'_item_'.$item['ID']);
                        }
                        $taggedCache->registerTag('iblock_id_'.$this->arParams['IBLOCK_ID']);
                        if (!empty($this->arResult['ITEMS'])) {
                            $this->arResult['SECTION_NAME'] = IblockTable::getById($this->arParams['IBLOCK_ID'])->fetch()['NAME'];
                        } else {
                            $taggedCache->abortTagCache();
                            $cache->abortDataCache();
                        }
                        $taggedCache->endTagCache();
                        $cache->endDataCache($this->arResult);
                    }

                    $this->includeComponentTemplate();

                } else {
                    throw new ArgumentNullException('IBLOCK_ID');
                }

            } else {
                throw new LoaderException(Loc::getMessage('CLASS_IBLOCK_MODULE_NOT_INSTALLED'));
            }
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }

    /**
     * @param $params
     * @return array
     */
    public function onPrepareComponentParams($params): array
    {
        return [
            'IBLOCK_TYPE' => trim($params['IBLOCK_TYPE']),
            'IBLOCK_ID' => intval($params['IBLOCK_ID']),
            'COUNT' => intval($params['COUNT']),
            'SORT_FIELD' => strlen($params['SORT_FIELD']) ? $params['SORT_FIELD'] : 'ID',
            'SORT_DIRECTION' => $params['SORT_DIRECTION'] == 'ASC' ? 'ASC' : 'DESC',
        ];
    }
}
