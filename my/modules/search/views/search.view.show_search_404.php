<?php
/**
 * Шаблон формы поиска по сайту, template=404
 *
 * Шаблонный тег <insert name="show_search" module="search" template="404"
 * [button="надпись на кнопке"]>:
 * форма поиска по сайту
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

echo '<div class="top-search">
	<form action="'.$result["action"].'" class="search-form" method="get">
		<input type="hidden" name="module" value="search">
		<input class="search-input" type="text" name="searchword">
		<input type="submit" value="">
	</form>
</div>';