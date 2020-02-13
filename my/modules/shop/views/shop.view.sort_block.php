<?php
/**
 * Шаблон блока «Сортировать» с ссылками на направление сортировки
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

$link_sort   = $result["link_sort"];
$sort_config = $result['sort_config'];

echo '<div class="block "><p>';

echo '<div class="sort-by by-rate">';

$symbol = '&uarr;';
for ($i = 1; $i <= count($sort_config['sort_directions']); $i++)
{
	echo empty($sort_config['sort_fields_names'][$i]) ? '' : '<a href="'.($link_sort[$i] ? BASE_PATH_HREF.$link_sort[$i] : '').'">' . $sort_config['sort_fields_names'][$i] . '</a>';
	if ($link_sort[$i])
	{
		echo ' <a href="'.BASE_PATH_HREF.$link_sort[$i].'" class="'.($symbol == '&uarr;' ?  'sort-up' :'sort-down').'">'.$symbol.'</a> ';
	}
	else
	{
		echo ' <span class="active '.($symbol == '&uarr;' ?  'sort-up active' :'sort-down active').'">'.$symbol.'</span> ';
	}

	$symbol =  $symbol == '&uarr;' ?  '&darr;' :'&uarr;';
}

echo '</div>';

echo '</p></div>';