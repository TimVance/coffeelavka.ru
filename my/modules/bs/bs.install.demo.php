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

class Bs_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"config" => array(
			array(
				"name" => "cat",
				"value" => "",
			),
		),
		"bs" => array(
			array(
				"name" => array("Слайд1"),
				"type" => 1,
				"file" => "4_1.jpg",
				"sort" => 1,
				"copy" => array("bs/4_1.jpg"),
			),
			array(
				"name" => array("Слайд2"),
				"type" => 1,
				"file" => "sl1_2.jpg",
				"sort" => 2,
				"copy" => array("bs/sl1_2.jpg"),
			),
			array(
				"name" => array("Слайд3"),
				"type" => 1,
				"file" => "sl1_3.jpg",
				"sort" => 3,
				"copy" => array("bs/sl1_3.jpg"),
			),
			array(
				"type" => 1,
				"file" => "banner_6.jpg",
				"sort" => 6,
				"copy" => array("bs/banner_6.jpg"),
			),
			array(
				"name" => array("дерево"),
				"type" => 1,
				"file" => "kofeynoe-derevo-1_7.jpg",
				"sort" => 7,
				"copy" => array("bs/kofeynoe-derevo-1_7.jpg"),
			),
			array(
				"name" => array("дерево"),
				"type" => 1,
				"file" => "kofeynoe-derevo_8.jpg",
				"sort" => 9,
				"copy" => array("bs/kofeynoe-derevo_8.jpg"),
			),
			array(
				"name" => array("123"),
				"type" => 1,
				"file" => "kofeynoe-derevo2_9.jpg",
				"sort" => 10,
				"copy" => array("bs/kofeynoe-derevo2_9.jpg"),
			),
			array(
				"name" => array("1"),
				"type" => 1,
				"file" => "kofeynoe-derevo_10.jpg",
				"sort" => 12,
				"copy" => array("bs/kofeynoe-derevo_10.jpg"),
			),
			array(
				"name" => array("3"),
				"type" => 1,
				"file" => "banner_6_11.jpg",
				"sort" => 11,
				"copy" => array("bs/banner_6_11.jpg"),
			),
			array(
				"name" => array("123156"),
				"type" => 1,
				"file" => "banner_6-1_12.jpg",
				"sort" => 8,
				"copy" => array("bs/banner_6-1_12.jpg"),
			),
			array(
				"name" => array("777"),
				"type" => 1,
				"file" => "banner_6-1_13.jpg",
				"sort" => 13,
				"copy" => array("bs/banner_6-1_13.jpg"),
			),
			array(
				"name" => array("кофан"),
				"type" => 1,
				"file" => "_mg_6972_14.jpg",
				"sort" => 14,
				"copy" => array("bs/_mg_6972_14.jpg"),
			),
			array(
				"name" => array("кофан"),
				"type" => 1,
				"file" => "_mg_6972_15.jpg",
				"sort" => 15,
				"copy" => array("bs/_mg_6972_15.jpg"),
			),
			array(
				"type" => 1,
				"file" => "fab73f24dfcd7b992daa9288f43cac2871f4a322_16.jpg",
				"sort" => 16,
				"copy" => array("bs/fab73f24dfcd7b992daa9288f43cac2871f4a322_16.jpg"),
			),
		),
	);
}