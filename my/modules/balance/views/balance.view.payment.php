<?php
/**
 * Шаблон формы платежной системы
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

if(! empty($result["message"]))
{
	echo $result["message"];
}

if(! empty($result["payment"]))
{	
	include_once(Custom::path('modules/payment/backend/'.$result["payment"].'/payment.'.$result["payment"].'.view.php'));
}