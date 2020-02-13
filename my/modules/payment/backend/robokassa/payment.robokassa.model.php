<?php
/**
 * Формирует данные для формы платежной системы Robokassa
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

class Payment_robokassa_model extends Diafan
{
	/**
     * Формирует данные для формы платежной системы "Robokassa"
     * 
     * @param array $params настройки платежной системы
     * @param array $pay данные о платеже
     * @return void
     */
	public function get($params, $pay)
	{
		//формирование подписи
		$crc = md5($params['robokassa_login'].":".$pay['summ'].":".$pay["id"].":".$params['robokassa_pass_1']);

		if(! empty($params["robokassa_test"]))
		{
			$link = "http://test.robokassa.ru/Index.aspx";
		}
		else
		{
			$link = "https://merchant.roboxchange.com/Index.aspx";
		}

		$link .= "?MrchLogin=".$params['robokassa_login']
		."&OutSum=".$pay["summ"]
		."&InvId=".$pay["id"]
		."&Desc=".$this->diafan->translit($pay["desc"])
		."&SignatureValue=".$crc;

		$this->diafan->redirect($link);
		exit;
	}
}