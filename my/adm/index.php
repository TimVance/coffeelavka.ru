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

$_GET["rewrite"] = preg_replace('/^'.preg_quote(ADMIN_FOLDER, '/').'[\/]*/', '', $_GET["rewrite"]);
$_GET["rewrite"] = str_replace('adm/', '', $_GET["rewrite"]);

define('IS_ADMIN', 1);

Custom::inc('adm/includes/init.php');

$diafan = new Init_admin();
$diafan->init();

exit;
