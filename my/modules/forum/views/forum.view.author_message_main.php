<?php
/**
 * Шаблон вывода информации о пользователе
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

if (! is_array($result))
{
	echo $result;
	return;
}
$name = $result["fio"].($result["name"] ? ' ('.$result["name"].')' : '');
if(! empty($result['user_page']))
{
	$name = '<a href="'.$result['user_page'].'"><strong>'.$name.'</strong></a>';
}
echo $name;