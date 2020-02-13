<?php
/**
 * Шаблон блока похожих товаров
 *
 * Шаблонный тег <insert name="show_block_rel" module="shop" [count="количество"]
 * [images="количество_изображений"] [images_variation="тег_размера_изображений"]
 * [template="шаблон"]>:
 * блок похожих товаров
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

if(empty($result['rows'])) return false;


	//echo '<h3>'.$this->diafan->_('Похожие товарыrrr').'</h3>
	echo '<h3>'.$this->diafan->_('Вместе с этим товаром покупают').'</h3>
	<div class="shop-pane row text-center">';
        echo $this->get('rows2','shop',$result);
	echo '</div>';
