<?php
/**
 * Шаблон блока товаров
 *
 * Шаблонный тег <insert name="show_block" module="shop" template="left" [count="количество"]
 * [cat_id="категория"] [site_id="страница_с_прикрепленным_модулем"] [brand_id="производитель"] 
 * [images="количество_изображений"] [images_variation="тег_размера_изображений"]
 * [sort="порядок_вывода"] [param="дополнительные_условия"]
 * [hits_only="только_хиты"] [action_only="только акции"] [new_only="только_новинки"]
 * [discount_only="только_со_скидкой"]
 * [only_module="только_на_странице_модуля"]>:
 * блок товаров
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
    $path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

if (empty($result["rows"]))
{
	return false;
}


echo '<div class="block">';

//заголовок блока
if (!empty($result["name"]))
{
	echo '<div class="block_header">'.$result["name"].'</div>';
}

$result["hide_compare"] = true;
//товары в разделе
echo $this->get('rows','shop',$result);
echo '</div>';