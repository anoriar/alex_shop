<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


/*************************************************************************
	Processing of received parameters
*************************************************************************/
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 180;


$arParams['IBLOCK_ID'] = 1;
if (filter_input(INPUT_POST, 'add')) {
    $name = filter_input(INPUT_POST, 'name');
    $text = filter_input(INPUT_POST, 'text');
    $url = filter_input(INPUT_POST, 'url');
    if (!empty($name) && !empty($text) && !empty($url)) {
        $el = new CIBlockElement;
        $arLoadItemArray = Array(
            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
            "IBLOCK_ID"      => $arParams['IBLOCK_ID'],
            "NAME"           => $name,
            "ACTIVE"         => "Y",            // активен
			"CODE"           =>  $name,
            "PREVIEW_TEXT"   => $text,
            "DETAIL_PAGE_URL" => $url
        );
        if($PRODUCT_ID = $el->Add($arLoadItemArray))
            echo "New ID: ".$PRODUCT_ID;
        else
            echo "Error: ".$el->LAST_ERROR;
    }
}

if($arParams['IBLOCK_ID'] > 0 && $this->StartResultCache(false, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}



	//SELECT
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		"PREVIEW_TEXT",
		"DETAIL_PICTURE",
		"DETAIL_PAGE_URL",
	);
	//WHERE
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	);
	if($arParams["PARENT_SECTION"]>0)
	{
		$arFilter["SECTION_ID"] = $arParams["PARENT_SECTION"];
		$arFilter["INCLUDE_SUBSECTIONS"] = "Y";
	}
	//ORDER BY
	$arSort = array(
		"SORT"=>"ASC",
	);
	//EXECUTE
	$rsIBlockElement = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
	$rsIBlockElement->SetUrlTemplates($arParams["DETAIL_URL"]);
	while($item = $rsIBlockElement->GetNext())
	{
        $arResult[] = $item;
	}
    $this->IncludeComponentTemplate();
}
?>
