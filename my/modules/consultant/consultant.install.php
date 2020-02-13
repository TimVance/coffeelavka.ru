<?php
/**
 * Установка модуля
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

class Consultant_install extends Install
{
	/**
	 * @var string название
	 */
	public $title = "On-line консультант";

	/**
	 * @var array записи в таблице {modules}
	 */
	public $modules = array(
		array(
			"name" => "consultant",
			"admin" => true,
			"site" => true,
		),
	);

	/**
	 * @var array меню административной части
	 */
	public $admin = array(
		array(
			"name" => "On-line консультант",
			"rewrite" => "consultant",
			"group_id" => "3",
			"sort" => 26,
			"act" => true,
			"children" => array(
				array(
					"name" => "JivoSite",
					"rewrite" => "consultant",
					"act" => true,
				),
				array(
					"name" => "LiveTex",
					"rewrite" => "consultant/livetex",
					"act" => true,
				),
				array(
					"name" => "RedHelper",
					"rewrite" => "consultant/redhelper",
					"act" => true,
				),
			),
		),
	);

	/**
	 * @var array настройки
	 */
	public $config = array(
		array(
			"name" => "redhelper_color",
			"value" => "#aacc66",
		),
		array(
			"name" => "redhelper_chatX",
			"value" => "30",
		),
		array(
			"name" => "redhelper_chatY",
			"value" => "50",
		),
		array(
			"name" => "redhelper_header",
			"value" => "Наша компания",
		),
		array(
			"name" => "redhelper_topText",
			"value" => "Лучшие товары",
		),
		array(
			"name" => "redhelper_welcome",
			"value" => "Вам чем-нибудь помочь?",
		),
		array(
			"name" => "redhelper_inviteTime",
			"value" => "20",
		),
		array(
			"name" => "redhelper_chatWidth",
			"value" => "200",
		),
		array(
			"name" => "redhelper_chatHeight",
			"value" => "300",
		),
	);
}