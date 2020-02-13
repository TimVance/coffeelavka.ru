<?php
/**
 * Шаблон аватара
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

// echo '<img src="'.BASE_PATH.USERFILES.'/avatar/'.$result["name"].'.png?'.rand(0, 99).'" width="'.$result["avatar_width"].'" height="'.$result["avatar_height"].'" alt="'.$result["fio"].' ('.$result["name"].')">
// <a href="javascript:void(0)" class="js_usersettings_avatar_delete usersettings_avatar_delete">x</a>';