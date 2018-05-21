<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("all_test");
?>
 <?

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array(
    "-" => GetMessage("IBLOCK_ANY"),
);

$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE" => "Y"));

while ($arr = $rsIBlock->Fetch()) {

    $arIBlock[$arr["ID"]] = "[" . $arr["ID"] . "] " . $arr["NAME"];
}



?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>