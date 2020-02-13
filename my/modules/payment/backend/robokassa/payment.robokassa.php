<?php
/**
 * Обработка данных, полученных от системы Robokassa
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

if (empty($_REQUEST["InvId"]))
{
	Custom::inc('includes/404.php');
}

$pay = $this->diafan->_payment->check_pay($_REQUEST["InvId"], 'robokassa');

if ($_GET["rewrite"] == "robokassa/result")
{
	$out_summ = $_REQUEST["OutSum"];
	$crc = $_REQUEST["SignatureValue"];
	$crc = strtoupper($crc);

	$my_crc = strtoupper(md5("$out_summ:".$pay["id"].":".$pay["params"]['robokassa_pass_2']));
		
	if (strtoupper($my_crc) != strtoupper($crc))
	{
		echo "bad sign\n";
		exit;
	}

	echo "OK".$pay["id"]."\n";
	exit;
}

if ($_GET["rewrite"] == "robokassa/success")
{
	$out_summ = $_REQUEST["OutSum"];
	$crc = $_REQUEST["SignatureValue"];
	$crc = strtoupper($crc);

	$my_crc = strtoupper(md5($out_summ.":".$pay["id"].":".$pay["params"]['robokassa_pass_1']));
	if (strtoupper($my_crc) == strtoupper($crc))
	{
		$this->diafan->_payment->success($pay);
	}
}
$this->diafan->_payment->fail($pay);
