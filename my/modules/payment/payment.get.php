<?php
/**
 * Работа с платежными системами
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

$rewrite_array = explode('/', $_GET["rewrite"]);

if(Custom::exists('modules/payment/backend/'.$rewrite_array[0].'/payment.'.$rewrite_array[0].'.php'))
{		
	include_once(Custom::path('modules/payment/backend/'.$rewrite_array[0].'/payment.'.$rewrite_array[0].'.php'));	
	exit;
}
else
{
	Custom::inc('includes/404.php');
}