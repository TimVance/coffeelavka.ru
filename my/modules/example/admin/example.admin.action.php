<?php
/**
 * Обработка POST-запросов
 * 
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://cms.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2014 OOO «Диафан» (http://diafan.ru)
 */

if (! defined('DIAFAN'))
{
	include dirname(dirname(dirname(__FILE__))).'/includes/404.php';
}

class Example_admin_action extends Action_admin
{
	/**
	 * Вызывает обработку Ajax-запросов
	 * 
	 * @return void
	 */
	public function init()
	{
		if (! empty($_POST["action"]))
		{
			switch($_POST["action"])
			{
				case 'user':
					$this->user();
					break;
			}
		}
	}

	/**
	 * Вызывает обработку Ajax-запросов
	 * 
	 * @return void
	 */
	public function user()
	{
		if (! empty($_POST['user_id']))
		{
			$this->result["name"] = DB::query_result("SELECT fio FROM {users} WHERE id='%d'", $_POST['user_id']);
		}
		else
		{
			$this->result["name"] = 'ошибка';
		}
	}
}