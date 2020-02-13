<?php
/**
 * Шаблон страницы новых сообщений
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
if(! empty($result["error"]))
{
	echo '<p>'.$this->diafan->_('Авторизуйтесь на сайте, чтобы увидеть новые сообщения.').'</p>';
	return;
}
foreach ($result["rows"] as $row)
{
	echo '<div class="js_forum_message forum_message">
		<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["theme"].'</a>
		<br>
		<span class="forum_author">'.$this->get('author', 'forum', $row["user"]).'</span>, <span class="forum_date">'.$row['created'].'</span>
		<br>
		'.$row['text'].'
	</div>';
}

echo $result["paginator"];

// форма поиска по темам и сообщениям
echo $this->get('form_search', 'forum', $result);