<?php
/**
 * Шаблон кнопки «Сравнить выбранные товары»
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

echo '
<form action="'.BASE_PATH_HREF.$result["shop_link"].'" method="GET" class="shop_compared_goods_list">
<input type="hidden" name="action" value="compare">';
if (isset($_SESSION['compare_list'][$result["site_id"]]))
{
	foreach ($_SESSION['compare_list'][$result["site_id"]] as $id => $dummy)
	{
		echo '<input type="hidden" name="ids[]" value="'.$id.'" class="shop_compared_goods_'.$id.'">';
	}
}
echo '

<input type="submit" value="'.$this->diafan->_('Сравнить выбранное', false).'" class="shop_compare_all_button">

</form>';