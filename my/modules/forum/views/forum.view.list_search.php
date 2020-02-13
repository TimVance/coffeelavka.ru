<?php
/**
 * Шаблон списка найденных сообщений
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

echo '<div class="forum_search_result">
	'.$this->diafan->_('Всего найдено').": <b>".$result["value"].": ".$result["count"]."</b>
	<br>
	".$this->diafan->_('Документы: <strong>%d—%d</strong> из %d найденных', true, $result["count"] ? 1 : 0, $result["count_page"], $result["count"]).'
</div>';

foreach ($result["rows"] as $row)
{
	if ($row["type"] == "message")
	{
		echo '<div class="js_forum_message forum_message">
			<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["theme"].'</a>
			<br>
			<span class="forum_author">'.$this->get('author', 'forum', $row["user"]).'</span>, <span class="forum_date">'.$row['created'].'</span>
			<br>
			'.$row['text'].'
		</div>';
	}
	else
	{
		echo '<div class="forum_category">
			<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["theme"].'</a>
			<br>
			<span class="forum_author">'.$this->get('author', 'forum', $row["user"]).'</span>, <span class="forum_date">'.$row['created'].'</span>
		</div>';
	}
}
echo $result["paginator"];

// форма поиска по темам и сообщениям
echo $this->get('form_search', 'forum', $result);