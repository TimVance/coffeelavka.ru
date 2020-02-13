<?php
/**
 * Шаблон списка элементов, к которым прикреплен тег
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

if (empty($result["rows"]))
	return false;

if (! empty($result["img"]))
{
	echo '<div class="news_all_img">';
	foreach ($result["img"] as $img)
	{
		switch($img["type"])
		{
			case 'animation':
				echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallerytags]">';
				break;
			case 'large_image':
				echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
				break;
			default:
				echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
				break;
		}
		echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
		.'</a>';
	}
	echo '</div>';
}

foreach ($result["rows"] as $module_name => $r)
{
	if (! empty($r["class"]))
	{
		echo $this->get($r["func"], $r["class"], $r);
	}
	else
	{
		echo '<div class="tags_list">';
		foreach ($r["rows"] as $row)
		{
			echo '
			<div class="tag_name"><a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a></div>
			<div class="tag_text">'.$row["snippet"].'</div>';
		}
		echo '</div>';
	}
}
//постраничная навигация
if (! empty($result["paginator"]))
{
	echo $result["paginator"];
}