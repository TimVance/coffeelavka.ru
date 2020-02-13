<?php
/**
 * Шаблонный тег: выводит путь до файла с учетом кастомизации.
 *
 * @param array $attributes атрибуты шаблонного тега
 * path - исходный путь до файла
 * absolute - путь абсолютный: **true** – тег выведет полный путь до файла, по умолчанию тег выведет относительный путь до файла без доменного имени
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

$attributes = $this->get_attributes($attributes, 'path', 'absolute');

if($attributes["absolute"] == 'true')
{
	echo BASE_PATH;
}
echo Custom::path($attributes["path"]);