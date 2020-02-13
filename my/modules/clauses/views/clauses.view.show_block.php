<?php
/**
 * Шаблон блока статей
 * 
 * Шаблонный тег <insert name="show_block" module="clauses" [count="количество"]
 * [cat_id="категория"] [site_id="страница_с_прикрепленным_модулем"]
 * [sort="порядок_вывода"]
 * [images="количество_изображений"] [images_variation="тег_размера_изображений"]
 * [only_module="только_на_странице_модуля"] [template="шаблон"]>:
 * блок статей
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

echo '<div class="block clauses">';

//заголовок блока
if (! empty($result["name"]))
{
	echo '<div class="block_header">'.$result["name"].'</div>';
}

//статьи
foreach ($result["rows"] as $row)
{
	echo '<div class="block-row '.(empty($row["img"]) ? 'block-no-img' : '').'">';

	//изображения статьи
	if (! empty($row["img"]))
	{
		echo '<div class="clauses_img">';
		foreach ($row["img"] as $img)
		{
			switch($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'clauses]" class="block-row-img">';
					break;
				case 'large_image':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'" class="block-row-img">';
					break;
				default:
					echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
					break;
			}
			echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'" class="block-row-img">'
			.'</a> ';
		}
		echo '</div>';
	}

	echo '<div class="block-text">';

	//название и ссылка статьи
	echo '<h4><a href="'.BASE_PATH_HREF.$row["link"].'" class="black">'.$row['name'].'</a></h4>';
	
	//рейтинг статьи
	if (! empty($row["rating"]))
	{
		echo '<div class="rate"> ' .$row["rating"] . '</div>';
	}	

	//анонс статьи	
	echo '<div class="anons"><a href="'.BASE_PATH_HREF.$row["link"].'" class="black">'.$row['anons'].'</a></div>';	

	if (! empty($row["date"]))
	{
		echo '<div class="date">'.$row["date"].'</div>';
	}

	echo '</div>';

	echo '</div>';
}

echo '</div>';