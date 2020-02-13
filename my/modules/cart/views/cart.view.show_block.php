<?php
/**
 * Шаблон блока корзины
 *
 * Шаблонный тег <insert name="show_block" module="cart" [template="шаблон"]>:
 * выводит информацию о заказанных товарах
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

echo '<span  style="font-size: 20px;" class="cart_block top-line-item">';
echo '<span class="show_cart js_show_cart">'.$this->get('info', 'cart', $result).'</span>';
echo '</span>';