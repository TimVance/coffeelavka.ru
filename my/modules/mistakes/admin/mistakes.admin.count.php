<?php
/**
 * Количество уведомлений об ошибоках на сайте
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
 * Mistakes_admin_count
 */
class Mistakes_admin_count extends Diafan
{
	/**
	 * Возвращает количество добавленных через форму ошибок на сайте
	 * @return integer
	 */
	public function count()
	{
		$count = DB::query_result("SELECT COUNT(*) FROM {mistakes}");
		return $count;
	}
}