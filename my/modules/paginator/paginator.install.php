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

class Paginator_install extends Install
{
	/**
	 * @var boolean модуль является частью ядра
	 */
	public $is_core = true;

	/**
	 * @var string название
	 */
	public $title = "Постраничная навигация";

	/**
	 * @var array записи в таблице {modules}
	 */
	public $modules = array(
		array(
			"name" => "paginator",
			"admin" => true,
			"site" => true,
		),
	);
}