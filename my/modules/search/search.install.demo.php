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

class Search_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"site" => array(
			array(
				"id" => 13,
				"name" => array("Поиск"),
				"rewrite" => "search",
				"sort" => 16,
				"module_name" => "search",
			),
		),
		"config" => array(
			array(
				"name" => "module_shop_current_index_module_table",
				"value" => "",
			),
			array(
				"name" => "module_shop_current_index_module_element",
				"value" => "",
			),
			array(
				"name" => "module_shop_current_index_site",
				"value" => "",
			),
			array(
				"name" => "module_shop_index",
				"value" => "",
			),
			array(
				"name" => "all_current_index_module_table",
				"value" => "",
			),
			array(
				"name" => "all_current_index_module_element",
				"value" => "",
			),
			array(
				"name" => "all_current_index_site",
				"value" => "",
			),
			array(
				"name" => "full_index",
				"value" => "1",
			),
			array(
				"name" => "module_news_current_index_module_table",
				"value" => "",
			),
			array(
				"name" => "module_news_current_index_module_element",
				"value" => "",
			),
			array(
				"name" => "module_news_current_index_site",
				"value" => "",
			),
			array(
				"name" => "module_news_index",
				"value" => "",
			),
			array(
				"name" => "module_clauses_current_index_module_table",
				"value" => "",
			),
			array(
				"name" => "module_clauses_current_index_module_element",
				"value" => "",
			),
			array(
				"name" => "module_clauses_current_index_site",
				"value" => "",
			),
			array(
				"name" => "module_clauses_index",
				"value" => "",
			),
			array(
				"name" => "module_photo_current_index_module_table",
				"value" => "",
			),
			array(
				"name" => "module_photo_current_index_module_element",
				"value" => "",
			),
			array(
				"name" => "module_photo_current_index_site",
				"value" => "",
			),
			array(
				"name" => "module_photo_index",
				"value" => "",
			),
		),
	);
}