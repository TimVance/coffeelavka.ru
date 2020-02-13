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

class Rating_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"rating" => array(
			array(
				"rating" => "5",
				"module_name" => "shop",
				"element_type" => "element",
				"element_id" => 211,
				"count_votes" => 1,
			),
			array(
				"rating" => "4",
				"module_name" => "shop",
				"element_type" => "element",
				"element_id" => 203,
				"count_votes" => 1,
			),
			array(
				"rating" => "4",
				"module_name" => "shop",
				"element_type" => "element",
				"element_id" => 185,
				"count_votes" => 1,
			),
			array(
				"rating" => "4",
				"module_name" => "shop",
				"element_type" => "element",
				"element_id" => 183,
				"count_votes" => 1,
			),
			array(
				"rating" => "4",
				"module_name" => "shop",
				"element_type" => "element",
				"element_id" => 186,
				"count_votes" => 1,
			),
			array(
				"rating" => "1",
				"module_name" => "shop",
				"element_type" => "element",
				"element_id" => 54,
				"count_votes" => 1,
			),
			array(
				"rating" => "5",
				"module_name" => "shop",
				"element_type" => "element",
				"element_id" => 65,
				"count_votes" => 1,
			),
		),
	);
}