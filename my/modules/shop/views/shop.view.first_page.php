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

//начало большого цикла, вывод категорий и товаров в них
foreach ($result["categories"] as $cat_id => $cat)
{
	echo '<div class=" js_shop_list shop_list">';

	//вывод названия категории
	echo '<div class="block_header"><a href="'.BASE_PATH_HREF.$cat["link_all"].'">'.$cat["name"].' ('.$cat["count"].')</a></div>';

	//вывод изображений категории
	if (!empty($cat["img"]))
	{
		echo '<div class="shop_cat_img">';
		foreach ($cat["img"] as $img)
		{
			switch ($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$cat_id.'shop]">';
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

	//краткое описание категории
	if (!empty($cat["anons"]))
	{
		echo '<div class="shop_cat_anons">'.$cat['anons'].'</div>';
	}

	//подкатегории
	if (!empty($cat["children"]))
	{
		foreach ($cat["children"] as $child)
		{
			echo '<div class="shop_cat_link">';

			//название и ссылка подкатегории
			echo '<a href="'.BASE_PATH_HREF.$child["link"].'">'.$child["name"].' ('.$child["count"].')</a></div>';

			//изображения подкатегории
			if (!empty($child["img"]))
			{
				echo '<div class="shop_cat_img">';
				foreach ($child["img"] as $img)
				{
					switch ($img["type"])
					{
						case 'animation':
							echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$child["id"].'shop]">';
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

			//краткое описание подкатегории
			if (!empty($child["anons"]))
			{
				echo '<div class="shop_cat_anons">'.$child['anons'].'</div>';
			}

			//вывод списка товаров подкатегории
			if (!empty($child["rows"]))
			{
				$res = $result;
				$res["rows"] = $child["rows"];
                                echo '<div class="shop-pane">';
				echo $this->get('rows', 'shop', $res);
                                echo '</div>';
			}
		}
	}

	//вывод товаров в категории
	if (!empty($cat["rows"]))
	{
		$res = $result;
		$res["rows"] = $cat["rows"];
                echo '<div class="row text-center shop-pane">';
		echo $this->get('rows', 'shop', $res);
                echo '</div>';
	}

	// ссылка на все товары в категории
	if ($cat["link_all"])
	{
		echo '<div class="show_all"><a href="'.BASE_PATH_HREF.$cat["link_all"].'">'
		. $this->diafan->_('Посмотреть все товары в категории «%s»', true, $cat["name"])
		. ' ('.$cat["count"].')</a></div>';
	}
	echo '</div>';
}

//постраничная навигация
if (!empty($result["paginator"]))
{
	echo $result["paginator"];
}