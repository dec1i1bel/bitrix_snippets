<?php

namespace Sprint\Migration;


class DemoDiscount_HL_20230206230340 extends Version
{
    protected $description = "Создаёт HL \"DemoDiscount\"";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $hlblockId = $helper->Hlblock()->saveHlblock(array (
  'NAME' => 'DemoDiscount',
  'TABLE_NAME' => 'demo_discount',
  'LANG' => 
  array (
    'ru' => 
    array (
      'NAME' => '[демо] Скидки',
    ),
    'en' => 
    array (
      'NAME' => '[demo] Discounts',
    ),
  ),
));
        $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_DISCOUNT_USER_ID',
  'USER_TYPE_ID' => 'integer',
  'XML_ID' => 'UF_DISCOUNT_USER_ID',
  'SORT' => '5',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'MIN_VALUE' => 0,
    'MAX_VALUE' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'en' => 'User ID',
    'ru' => 'ID пользователя',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'en' => 'User ID',
    'ru' => 'ID пользователя',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'en' => 'User ID',
    'ru' => 'ID пользователя',
  ),
  'ERROR_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_DISCOUNT_PERCENTAGE',
  'USER_TYPE_ID' => 'integer',
  'XML_ID' => 'UF_DISCOUNT_PERCENTAGE',
  'SORT' => '10',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'MIN_VALUE' => 0,
    'MAX_VALUE' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'en' => 'Discount percentage',
    'ru' => 'Процент скидки',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'en' => 'Discount percentage',
    'ru' => 'Процент скидки',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'en' => 'Discount percentage',
    'ru' => 'Процент скидки',
  ),
  'ERROR_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_DISCOUNT_PROMOCODE',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => 'UF_DISCOUNT_PROMOCODE',
  'SORT' => '20',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => '',
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'en' => 'Promocode',
    'ru' => 'Промокод',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'en' => 'Promocode',
    'ru' => 'Промокод',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'en' => 'Promocode',
    'ru' => 'Промокод',
  ),
  'ERROR_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_DISCOUNT_END_TIMESTAMP',
  'USER_TYPE_ID' => 'integer',
  'XML_ID' => 'UF_DISCOUNT_END_TIMESTAMP',
  'SORT' => '30',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'MIN_VALUE' => 0,
    'MAX_VALUE' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'en' => 'Discount end timestamp',
    'ru' => 'Timestamp окончания действия',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'en' => 'Discount end timestamp',
    'ru' => 'Timestamp окончания действия',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'en' => 'Discount end timestamp',
    'ru' => 'Timestamp окончания действия',
  ),
  'ERROR_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
));
        }

    public function down()
    {
        //your code ...
    }
}
