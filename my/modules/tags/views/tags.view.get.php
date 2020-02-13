<?php
/**
 * Шаблон списка прикрепленных к элементу тегов
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

if (! empty($result))
{
	$k = 0;
	echo '
	<div class="tags"><span class="tags_header">'.$this->diafan->_('Теги').':</span> ';
	foreach ($result as $row)
	{
		echo ($k ? ', ' : '').'<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a>
		';
		$k++;
	}
	echo '</div>';
}