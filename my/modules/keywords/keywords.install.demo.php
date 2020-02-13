<?php
/**
 * Установка модуля
 *
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined("DIAFAN"))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

class Keywords_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"keywords" => array(
			array(
				"id" => 1,
				"text" => "david rio",
				"link" => "/shop/pryanyy-chay-latte-david-rio-chai/",
			),
			array(
				"id" => 2,
				"text" => "Дэвида Рио",
				"link" => "/shop/pryanyy-chay-latte-david-rio-chai/",
			),
			array(
				"id" => 3,
				"text" => "чёрного чая",
				"link" => "/shop/listovoy-chay/indiyskiy-chay/",
			),
			array(
				"id" => 4,
				"text" => "промоматериалы",
				"link" => "http://p8.hostingprod.com/@davidrio.com/protected/index.html",
			),
			array(
				"id" => 5,
				"text" => "Колумбия",
				"link" => "BASE_PATHshop/svezheobzharennyy-kofe-v-zernakh/kolumbiya-kindio-250-gr/",
			),
		),
	);
}