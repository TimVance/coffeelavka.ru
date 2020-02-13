<?php
/**
 * Количество неотвеченных сообщений из формы обратной связи для меню административной панели
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
 * Feedback_admin_count
 */
class Feedback_admin_count extends Diafan
{
	/**
	 * Возвращает количество неотвеченных сообщений из формы обратной связи для меню административной панели
	 * @param integer $site_id страница сайта, к которой прикреплен модуль
	 * @return integer
	 */
	public function count($site_id)
	{
		$count = DB::query_result("SELECT COUNT(*) FROM {feedback} WHERE readed='0' AND trash='0'".($site_id ? " AND site_id=".$site_id : ""));
		return $count;
	}
}