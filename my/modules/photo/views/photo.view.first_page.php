<?php
/**
 * Шаблон первой страницы модуля, если в настройках модуля подключен параметр «Использовать категории»
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

if (empty($result["categories"]))
	return false;

echo '<div class="photo_first_page">';

//вывод альбомов

foreach ($result["categories"] as $cat_id => $cat)
{

	echo '<div class="photo_cat">';

	//название альбома
	echo '<a href="'.BASE_PATH_HREF.$cat["link_all"].'" class="photo_cat_link">'.$cat["name"].' ('.$cat["count"].')</a>';

	//рейтинг альбома
	if (! empty($cat["rating"]))
	{
		echo '<div class="photo_cat_rating">'.$cat["rating"].'</div>';
	}

	//вывод изображений альбома
	if (! empty($cat["img"]))
	{
		echo '<div class="photo_cat_img">';
		foreach ($cat["img"] as $img)
		{
			switch($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$cat_id.'photo]">';
					break;
				case 'large_image':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
					break;
				default:
					echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
					break;
			}
			echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
			.'</a> ';
		}
		echo '</div>';
	}
	else
	{
		//вывод нескольких фотографий из текущей категории (задается в настройках модуля)
		if ($cat["rows"])
		{
			echo '<div class="photo_cat_images">';
			echo $this->get('rows','photo',$cat);
			echo '</div>';
		}
	}


	//краткое описание альбома
	if (! empty($cat["anons"]))
	{
		echo '<div class="photo_cat_anons">'.$cat['anons'].'</div>';
	}

	echo '</div>';
}

echo '</div>';


//постраничная навигация
if (! empty($result["paginator"]))
{
	echo $result["paginator"];
}