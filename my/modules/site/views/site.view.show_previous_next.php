<?php
/**
 * Шаблон ссылок на предыдущую и следующую страницы сайта
 *
 * Шаблонный тег <insert name="show_previous_next" module="site" [template="шаблон"]>:
 * выводит ссылки на предыдующую и следующую страницы
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

if (! $result["previous"] && ! $result["next"])
{
	return;
}
echo '<div class="previous_next_links">';
if ($result["previous"])
{
	echo '<div class="previous_link"><a href="'.BASE_PATH_HREF.$result["previous"]["link"].'">&larr; '.$result["previous"]["name"].'</a></div>';
}
if ($result["next"])
{
	echo '<div class="next_link"><a href="'.BASE_PATH_HREF.$result["next"]["link"].'">'.$result["next"]["name"].' &rarr;</a></div>';
}
echo '</div>';
