<?php
/**
 * @package    DIAFAN.CMS
 * Admin bootstrap
 *
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

$brandtext = array(
    
'© 2003-'.date("Y").' <a href="http://www.diafan.ru/" target="_blank">www.diafan.ru</a><br>
DIAFAN.CMS версия '.VERSION_CMS,

);
