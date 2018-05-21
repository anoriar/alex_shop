<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$frame = $this->createFrame()->begin('');
?>
<div class="catalog">
    <?foreach ($arResult as $item):?>
        <a href="<?= $item['DETAIL_PAGE_URL']?>"><?= $item["NAME"] ?></a>
        <p><?= $item["PREVIEW_TEXT"] ?></p>
        <br>
    <?endforeach;?>
    <form action="test2.php" method="post">
        Имя: <input type="text" name="name" value="" /><br>
        Текст: <input type="text" name="text" value="" /><br>
        Cсылка: <input type="text" name="url" value="" /><br>
        <input type="submit" value="Добавить" name="add" />
    </form>
</div>
<?
$frame->end();
?>