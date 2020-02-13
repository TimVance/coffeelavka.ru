<?php
/**
 * Администрирование импорта/экспорт данных
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

/**
 * Подключает редактирование списка категорий или полей
 */
function inc_file_shop($diafan)
{
	if ($diafan->_route->cat)
	{
		Custom::inc("modules/shop/admin/shop.admin.importexport.element.php");
		return 'Shop_admin_importexport_element';
	}
	else
	{
		Custom::inc("modules/shop/admin/shop.admin.importexport.category.php");
		return 'Shop_admin_importexport_category';
	}
}