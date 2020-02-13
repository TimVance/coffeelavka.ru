<?php
/**
 * Шаблон постраничной навигации для пользовательской части
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

if ($result)
{
	echo '<ul class="pagination">';
	foreach ($result as $l)
	{
		switch($l["type"])
		{
			case "first":
				echo '<li><a class="start" href="'.BASE_PATH_HREF.$l["link"].'">&#171;</a></li> ';
				break;

			case "current":
				echo '<li><span class="active">'.$l["name"].'</span> </li>';
				break;

			case "previous":
				echo '<li><a class="prev" href="'.BASE_PATH_HREF.$l["link"].'" title="'.$this->diafan->_('На предыдущую страницу', false).'">...</a></li> ';
				break;

			case "next":
				echo '<li><a class="next" href="'.BASE_PATH_HREF.$l["link"].'" title="'.$this->diafan->_('На следующую страницу', false).' '.$this->diafan->_('Всего %d', false, $l["nen"]).'">...</a></li> ';
				break;

			case "last":
				echo '<li><a class="end" href="'.BASE_PATH_HREF.$l["link"].'">&#187;</a></li> ';
				break;

			default:
				echo '<li><a href="'.BASE_PATH_HREF.$l["link"].'">'.$l["name"].'</a></li> ';
				break;
		}
	}
	echo '</ul>';
}