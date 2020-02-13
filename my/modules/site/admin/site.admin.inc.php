<?php
/**
 * Подключение модуля к административной части других модулей
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

/**
 * Site_admin_inc
 */
class Site_admin_inc extends Diafan
{
	/**
	 * Блокирует/разблокирует страницы сайта
	 * 
	 * @param string $table таблица
	 * @param array $element_ids номера элементов, к которым прикреплены теги
	 * @param integer $act блокировать/разблокировать
	 * @return void
	 */
	public function act($table, $element_ids, $act)
	{
		if ($table != "site")
		{
			return;
		}
		// при активации|деактивации страниц сайта нужно чистить кэш модуля, который прикреплен к странице
		$module_names = DB::query_fetch_value("SELECT module_name FROM {site} WHERE id IN (%s)", implode(",", $element_ids), "module_name");
		$module_names = array_unique($module_names);
		foreach($module_names as $module_name)
		{
			if($module_name)
			{
				$this->diafan->_cache->delete("", $module_name);
			}
		}
	}
}