<?php
/**
 * Шаблонный тег: подключает файл-блок шаблона.
 *
 * @param array $attributes атрибуты шаблонного тега
 * file - имя PHP-файла из папки *themes/blocks* без расширения
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

$attributes = str_replace('/[^a-z_0-9]+/', '', $this->get_attributes($attributes, 'file'));

$inc = file_get_contents(Custom::path('themes/blocks/'.$attributes["file"].'.php'));

echo $this->get_function_in_theme($inc, true);