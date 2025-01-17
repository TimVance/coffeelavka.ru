<?php
/**
 * Ошибка 404. Страница не найдена
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

if(! defined('DIAFAN'))
{
	$_GET["rewrite"] = '404';
	include_once dirname(dirname(__FILE__)).'/index.php';
}
else
{
	global $diafan;

	Custom::inc('includes/controller.php');
	$diafan->_site->theme = '404.php';

	header('HTTP/1.0 404 Not Found');
	header('Content-Type: text/html; charset=utf-8');

	$mod = new Controller($diafan);
	$diafan->_parser_theme->show_theme($mod);
}

exit;