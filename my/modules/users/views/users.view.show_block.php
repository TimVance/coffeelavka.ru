<?php
/**
 * Шаблон статистики пользователей на сайте
 * 
 * Шаблонный тег <insert name="show_block" module="users">:
 * выводит статистику пользователей на сайте
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

if (! $result)
{
	return;
}
echo '<div class="show_users">'.$this->diafan->_('Сейчас на сайте: %s гостей, %s пользователей.', true, $result["count_user"], $result["count_user_auth"]).'</div>';
