<?php
/**
 * Шаблон результатов поиска по сайту
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

if(! $result["ajax"])
{
	// echo $this->htmleditor('<insert name="show_search" module="search" button="Найти" template="top">');
}
if (! empty($result["value"]))
{
	if(! $result["ajax"])
	{
		echo '<p>'.$this->diafan->_('Всего найдено').": <b>".$result["value"].": ".$result["count"]."</b>
		<br>".$this->diafan->_('Документы: <strong>%d—%d</strong> из %d найденных', true, $result["count_start"], $result["count_finish"], $result["count"])
		.'</p>';
	}
	else
	{
		if(empty($result["rows"]))
		{
			echo '<p>'.$this->diafan->_('Извините, ничего не найдено.').'</p>';
		}
	}

	foreach ($result["rows"] as $module_name => $res)
	{
		if (! empty($res["class"]))
		{
			echo $this->get($res["func"], $res["class"], $res);
		}
		else
		{
			echo '<div class="container search_list"><div class="row">';
			foreach ($res["rows"] as $row)
			{
				echo '
				<div class="search_name"><a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a></div>
				<div class="search_text">'.$row["snippet"].'</div>';
			}
			echo '</div></div>';
		}
	}
	echo (!empty($result["paginator"]) ? $result["paginator"] : '');
}
else
{
	if(! $result["ajax"])
	{
		echo '<p>'.$this->diafan->_('Слово для поиска не задано.').'</p>';
	}
}
