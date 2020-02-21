<?php
/**
 * Шаблонный тег: выводит информацию о Политике конфиденциальности.
 *
 * @param array $attributes атрибуты шаблонного тега
 * attribute string text - текст сообщения
 * attribute boolean hash - сравнивать hash сообщения
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
	$path = __FILE__;
	while(! file_exists($path.'/includes/404.php'))
	{
		$parent = dirname($path);
		if($parent == $path) exit;
		$path = $parent;
	}
	include $path.'/includes/404.php';
}

$text = (! empty($text) ? $text : $this->diafan->_('На этом сайте используются файлы cookie. Продолжая просмотр сайта, вы разрешаете их использование. %sПодробнее%s.', true, '<a href="'.BASE_PATH_HREF.'privacy-policy'.ROUTE_END.'" target="_blank">', '</a>'));

if ($_COOKIE["privacy_close"] != "true") echo '<div class="privacy_policy">'.$text.' <span class="button" onclick="privacy_close()">'.$this->diafan->_('Закрыть', true).'</span>'.'</div>';
