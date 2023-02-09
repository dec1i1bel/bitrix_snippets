<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $APPLICATION;

$APPLICATION->IncludeComponent(
	"demo:items", 
	"index.php", 
	array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"COUNT" => "",
		"SORT_FIELD" => "ID",
		"SORT_DIRECTION" => "ASC",
		"SEF_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "index.php",
		"SEF_FOLDER" => "/local/demo_pages/",
		"SEF_URL_TEMPLATES" => array(
			"index" => "index.php",
			"detail" => "#ELEMENT_ID#/",
		)
	),
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
