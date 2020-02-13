<?php
/**
 * Модель модуля «Пользователи на сайте»
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
 * Users_model
 */
class Users_model extends Model
{
	/**
	 * Генерирует данные для
	 * шаблонного тега <insert name="show_block" module="users">:
	 * выводит статистику пользователей на сайте
	 * 
	 * @return array
	 */
	public function show_block()
	{
		$timestamp = time() - 900;
		$result["count_user"]      = 0;
		$result["count_user_auth"] = 0;
		$rows = DB::query_fetch_all("SELECT user_id FROM {sessions} WHERE timestamp>=%d", $timestamp);
		foreach($rows as $r)
		{
			if($r["user_id"])
			{
				$result["count_user_auth"]++;
			}
			else
			{
				$result["count_user"]++;
			}
		}
		return $result;
	}
}
