<?php
/**
 * Шаблон страницы новости
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

echo '<div class="news news_id">';

//вывод даты новости
if (! empty($result["date"]))
{
	echo '<div class="news_date">'.$result["date"]."</div>";
}

//изображения новости
if (! empty($result["img"]))
{
	echo '<div class="news_all_img">';
	foreach ($result["img"] as $img)
	{
		switch($img["type"])
		{
			case 'animation':
				echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$result["id"].'news]">';
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

echo $this->htmleditor('<insert name="show_dynamic" module="site" id="1">');

//вывод основного текста новости
echo '<div class="news_text">'.$this->htmleditor($result['text']).'</div>';

//счетчик просмотров
if(! empty($result["counter"]))
{
	echo '<div class="news_counter">'.$this->diafan->_('Просмотров').': '.$result["counter"].'</div>';
}

//вывод тегов к новости
if (! empty($result["tags"]))
{
	echo $result["tags"];
}

//рейтинг новости
if (! empty($result["rating"]))
{
	echo $result["rating"];
}

//комментарии к новости
if (! empty($result["comments"]))
{
	echo $result["comments"];
}

echo $this->htmleditor('<insert name="show_block_rel" module="news" count="3" images="1">');

//ссылки на предыдущую и последующую новость
if (! empty($result["previous"]) || ! empty($result["next"]))
{
	echo '<ul class="pager">';
	if (! empty($result["previous"]))
	{
		echo '<li class="previous"><a href="'.BASE_PATH_HREF.$result["previous"]["link"].'">&larr; '.$result["previous"]["text"].'</a></li>';
	}
	if (! empty($result["next"]))
	{
		echo '<li class="next"><a href="'.BASE_PATH_HREF.$result["next"]["link"].'">'.$result["next"]["text"].' &rarr;</a></li>';
	}
	echo '</ul>';
}

//ссылки на все новости
if (! empty($result["allnews"]))
{
	echo '<div class="show_all"><a href="'.BASE_PATH_HREF.$result["allnews"]["link"].'">'.$this->diafan->_('Вернуться к списку').'</a></div>';
}

echo '</div>';