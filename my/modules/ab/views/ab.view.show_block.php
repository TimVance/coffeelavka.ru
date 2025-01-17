<?php
/**
 * Шаблон блока объявлений
 * 
 * Шаблонный тег <insert name="show_block" module="ab" [count="количество"]
 * [cat_id="категория"] [site_id="страница_с_прикрепленным_модулем"]
 * [images="количество_изображений"] [images_variation="тег_размера_изображений"]
 * [sort="порядок_вывода"] [param="дополнительные_условия"]
 * [only_as="выводить_только_на_странице_модуля"] [template="шаблон"]>:
 * блок объявлений
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

echo '<div class="ab_block">';

//заголовок блока
if (!empty($result["name"]))
{
	echo '<div class="block_header">'.$result["name"].'</div>';
}

//объявления
if (!empty($result["rows"]))
{
	foreach ($result["rows"] as $row)
	{
		echo '<div class="js_ab ab">';

		//дата
		if (! empty($row["date"]))
		{
			echo '<div class="ab_date">'.$row["date"].'</div>';
		}
		
		//название и ссылка
		echo '<div class="ab_name"><a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a>';
		//рейтинг объявления
		if (!empty($row["rating"]))
		{
			echo ' '.$row["rating"];
		}
		echo '</div>';

		//изображения
		if (!empty($row["img"]))
		{
			echo '<div class="ab_img">';
			foreach ($row["img"] as $img)
			{
				switch ($img["type"])
				{
					case 'animation':
						echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'ab]">';
						break;
					case 'large_image':
						echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
						break;
					default:
						echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
						break;
				}
				echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
				. '</a> ';
			}
			echo '</div>';
		}

		// параметры товара
		if (!empty($row["param"]))
		{
			echo $this->get('param', 'ab', array("rows" => $row["param"], "id" => $row["id"]));
		}

		//краткое описание
		if (!empty($row["anons"]))
		{
			echo '<div class="ab_anons">'.$row['anons'].'</div>';
		}

		//теги объявления
		if (!empty($row["tags"]))
		{
			echo $row["tags"];
		}
		echo '</div>';
	}
}

//ссылка на все объявления
if (!empty($result["link_all"]))
{
	echo '<div class="show_all"><a href="'.BASE_PATH_HREF.$result["link_all"].'">';
	if ($result["category"])
	{
		echo $this->diafan->_('Посмотреть все объявления в категории «%s»', true, $result["name"]);
	}
	else
	{
		echo $this->diafan->_('Все объявления');
	}
	echo '</a></div>';
}

echo '</div>';