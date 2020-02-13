<?php
/**
 * Формирует данные для страницы оплаты безналичным платежем
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

class Payment_non_cash_model extends Model
{
	/**
	 * Формирует данные для страницы оплаты безналичным платежем
     *
     * @param array $params настройки платежной системы
     * @param array $pay данные о платеже
     * @return array
     */
	public function get($params, $pay)
	{
		$result["code"] = $pay["code"];
		$result["text"] = $pay['text'];
		$result["id"]   = $pay["id"];
		return $result;
	}
	
	////////////////////////////
	
	public function show()
	{
		//$rows333 = DB::query_range_fetch_all("SELECT name1 FROM {payment} WHERE id=1"
 		//return $rows333;
	}

	//////////////////////////
	
}