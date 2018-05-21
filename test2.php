<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test2");
?>Text here....<?$APPLICATION->IncludeComponent(
	"my:my.news.list",
	"",
Array()
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>