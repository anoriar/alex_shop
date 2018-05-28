<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

$defaultParams = array(
	'TEMPLATE_THEME' => 'blue'
);
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$templateId = (string)Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
		$arParams['TEMPLATE_THEME'] = (string)Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';


if (CModule::IncludeModule('iblock')){
    $dbItem = CIBlock::GetList(Array(), Array('CODE' => "clothes"), false)->Fetch();
    $iblock_id = $dbItem["ID"];
}

//** Добавлениеа свойства "Страна производитель в массив arResult */
foreach($arResult["BASKET_ITEM_RENDER_DATA"] as $item => $val) {
    $arItemSelect = Array("ID", "NAME", "IBLOCK_ID");
    $arItemFilter = Array("NAME" => $val["NAME"], "ACTIVE"=>"Y");
    if($dbItem = CIBlockElement::GetList(Array(), $arItemFilter, false, Array("nPageSize"=>50), $arItemSelect)) {
        $resItem = $dbItem->Fetch();
        if($db_prop = CIBlockElement::GetProperty($resItem["IBLOCK_ID"], $resItem["ID"], array("sort" => "asc"), Array("CODE"=>"COUNTRY"))){
            $prop = $db_prop->Fetch();
            $country_prop = [
                "CODE" => $prop["CODE"],
                "NAME" => $prop["NAME"],
                "VALUE" => $prop["VALUE"],
                "IS_TEXT" => true,
                "HIDE_MOBILE" => true,
           ];
            $arResult["BASKET_ITEM_RENDER_DATA"][$item]["COLUMN_LIST"][] = $country_prop;
        }
    }
}