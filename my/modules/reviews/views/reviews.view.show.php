<?php
/**
 * Шаблон вывода отзывов
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

echo '<div class="block reviews">';
echo '<div class="block_header">'.$this->diafan->_('Отзывы').'</div>';

foreach ($result["rows"] as $row)
{
	echo $this->get('id', 'reviews', $row);
}
echo '</div>';

//постраничная навигация
if (! empty($result["paginator"]))
{
	echo $result["paginator"];
}

if($result["form"])
{
	echo $this->get('form', 'reviews', $result["form"]);
}
if($result["register_to_review"])
{
	echo $this->diafan->_('Чтобы оставить отзыв, зарегистрируйтесь или авторизуйтесь.');
}