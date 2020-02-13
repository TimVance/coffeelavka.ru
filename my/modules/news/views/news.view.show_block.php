<?php
/**
 * Шаблон блока новостей
 *
 * Шаблонный тег <insert name="show_block" module="news" [count="количество"]
 * [cat_id="категория"] [site_id="страница_с_прикрепленным_модулем"]
 * [images="количество_изображений"] [images_variation="тег_размера_изображений"]
 * [only_module="только_на_странице_модуля"] [template="шаблон"]>:
 * блок новостей
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
{
	return false;
}

echo '<div class="row news_block">';

// заголовок блока
if (! empty($result["name"]))
{
	echo '<div class="col-md-12 h3">'.$result["name"].'</div>';
}

//новости
foreach ($result["rows"] as $row)
{

	echo '<div class="col-md-4 media '.(empty($row["img"]) ? 'block-no-img' : '').'">';

	// echo '<div class="media-left">';

	//изображения новости
	if (! empty($row["img"]))
	{
		foreach ($row["img"] as $img)
		{
			switch($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'news]" class="block-row-img">';
					break;
				case 'large_image':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'" class="block-row-img">';
					break;
				default:
					echo '<a href="'.BASE_PATH_HREF.$img["link"].'" class="block-row-img">';
					break;
			}
			echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'" class="media-object">'
			.'</a> ';
		}
	}

	// echo '</div>';

	echo '<div class="media-body">';

		//название и ссылка новости
		echo ' <h4 class="media-heading"><a href="'.BASE_PATH_HREF.$row["link"].'" class="black">'.$row['name'].'</a></h4>';

		//рейтинг новости
		if (! empty($row["rating"]))
		{
			echo '<div class="news_rating rate"> ' .$row["rating"] . '</div>';
		}

	    //анонс новости
		echo '<div class="news_anons text-muted">'.$row['anons'].'</div>';

		//дата новости
		if (! empty($row["date"]))
		{
			echo '<div class="news_date date">'.$row["date"].'</div>';
		}

	echo '</div>';

	echo '</div>';
}

echo '</div>';


//ссылка на все новости
if (! empty($result["link_all"]))
{
echo '<br><br><div class="text-center"><a class="btn btn-warning btn-danger_mod btn-sm" href="'.BASE_PATH_HREF.$result["link_all"].'">';
if ($result["category"])
{
echo $this->diafan->_('Посмотреть все новости в категории «%s»', true, $result["name"]);
}
else
{
echo $this->diafan->_('Все новости');
}
echo '</a></div>';
}