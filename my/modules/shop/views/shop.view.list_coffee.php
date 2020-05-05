<?php
/**
 * Шаблон списка товаров
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
	echo '<p>'.$result["error"].'</p>';
	return;
}

if(empty($result["ajax"]))
{
	echo '<div class="js_shop_list shop_list ">';
}

//вывод описания текущей категории
if (!empty($result["text"]))
{
	echo '<div class="shop_text text media">';
	//вывод изображений текущей категории
	if (!empty($result["img"]))
	{
		//echo '<div class="shop_cat_all_img media-left">';
		foreach ($result["img"] as $img)
		{
			switch ($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$result["id"].'shop_cat]">';
					break;
				case 'large_image':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
					break;
				default:
					echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
					break;
			}
			echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'" hspace="5" align="left">'
			. '</a> ';
		}
		//echo '</div>';
	}
	//echo '<div class="block-text media-body">'.$result['text'].'</div>';
	echo $result['text'];

	echo '</div>';
}
else
{
	//вывод изображений текущей категории
	if (!empty($result["img"]))
	{
		echo '<div class="shop_cat_all_img">';
		foreach ($result["img"] as $img)
		{
			switch ($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$result["id"].'shop_cat]">';
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
}

echo '<div class="row">';

//вывод подкатегории
if (!empty($result["children"]))
{
	foreach ($result["children"] as $child)
	{
		echo '<div class="shop_cat_link col-md-4">';

		//вывод изображений подкатегории
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

		//название и ссылка подкатегории
		echo '<a href="'.BASE_PATH_HREF.$child["link"].'">'.$child["name"].' ('.$child["count"].')</a>';

		//краткое описание подкатегории
		// if ($child["anons"])
		// {
		// 	echo '<div class="shop_cat_anons">'.$child['anons'].'</div>';
		// }
		echo '</div>';


	}
}

echo '</div>';


//вывод списка товаров подкатегории
if (!empty($child["rows"]))
{
	$res = $result;
	$res["rows"] = $child["rows"];
                echo '<div class="shop-pane">';
	echo $this->get('rows', 'shop', $res);
                echo '</div>';
}

//вывод списка товаров
if (!empty($result["rows"]))
{
    	//вывод сортировки товаров
	if(! empty($result["link_sort"]))
	{
		echo $this->get('sort_block', 'shop', $result);
	}

	echo '<div class="row text-center shop-pane">';
	    echo $this->get('rows_coffee', 'shop', $result);
    echo '</div>';
}

//постраничная навигация
if (!empty($result["paginator"]))
{
	echo $result["paginator"];
}

// if (!empty($result["rows"]) && empty($result["hide_compare"]))
// {
// 	echo $this->get('compared_goods_list', 'shop', array("site_id" => $this->diafan->_site->id, "shop_link" => $result['shop_link']));
// }

//вывод ссылок на предыдущую и последующую категории
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

//вывод комментариев ко всей категории товаров (комментарии к конкретному товару в функции id())
if (!empty($result["comments"]))
{
	echo $result["comments"];
}

if(empty($result["ajax"]))
{
	echo '</div>';
}