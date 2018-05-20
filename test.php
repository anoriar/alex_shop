<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?><?$APPLICATION->IncludeComponent(
	"my:iblock.element.add.list.v2",
	".default",
Array()
);?>
Text here....<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>