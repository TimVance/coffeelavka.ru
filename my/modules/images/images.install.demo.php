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

class Images_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"images_variations" => array(
			array(
				"id" => 1,
				"name" => "Маленькое изображение (превью)",
				"folder" => "small",
				"param" => "a:1:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";i:180;s:6:\"height\";i:180;s:3:\"max\";i:0;}}",
				"quality" => 90,
			),
			array(
				"id" => 2,
				"name" => "Среднее изображение",
				"folder" => "medium",
				"param" => "a:1:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:3:\"max\";i:0;}}",
				"quality" => 90,
			),
			array(
				"id" => 3,
				"name" => "Большое изображение (полная версия)",
				"folder" => "large",
				"param" => "a:1:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";i:1200;s:6:\"height\";i:1200;s:3:\"max\";i:0;}}",
				"quality" => 90,
			),
			array(
				"id" => 4,
				"name" => "Превью товара",
				"folder" => "preview",
				"param" => "a:1:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";s:3:\"113\";s:6:\"height\";s:3:\"113\";s:3:\"max\";i:0;}}",
				"quality" => 90,
			),
		),
	);
}