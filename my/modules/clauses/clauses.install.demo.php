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

class Clauses_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"site" => array(
			array(
				"id" => 37,
				"name" => array("Статьи"),
				"rewrite" => "clauses",
				"sort" => 37,
				"menu" => "2",
				"module_name" => "clauses",
				"parent_id" => "2",
			),
		),
		"config" => array(
			array(
				"name" => "format_date",
				"value" => "1",
			),
			array(
				"name" => "images_variations_element",
				"value" => "a:2:{i:0;a:2:{s:4:\"name\";s:5:\"large\";s:2:\"id\";s:1:\"3\";}i:1;a:2:{s:4:\"name\";s:6:\"medium\";s:2:\"id\";s:1:\"1\";}}",
			),
			array(
				"name" => "images_variations_cat",
				"value" => "a:2:{i:0;a:2:{s:4:\"name\";s:5:\"large\";s:2:\"id\";s:1:\"4\";}i:1;a:2:{s:4:\"name\";s:6:\"medium\";s:2:\"id\";s:1:\"4\";}}",
			),
			array(
				"name" => "rating",
				"value" => "1",
			),
			array(
				"name" => "keywords",
				"value" => "1",
			),
		),
		"clauses_category" => array(
			array(
				"id" => 1,
				"name" => array("Статьи"),
				"rewrite" => "clauses/stati",
				"sort" => 1,
			),
		),
		"clauses" => array(
			array(
				"id" => 1,
				"cat_id" => 1,
				"name" => array("О свежести кофе"),
				"rewrite" => "clauses/stati/o-svezhesti-kofe",
				"sort" => 1,
			),
		),
	);
}