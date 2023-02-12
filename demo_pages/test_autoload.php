<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Demo\TestClass;

TestClass::printTestMessage();

printr(intval('678'));
