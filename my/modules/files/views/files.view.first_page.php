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

//категории
foreach ($result["categories"] as $cat_id => $cat)
{
	echo '<div class="files_list">';

	//название категории
	echo '<div class="block_header">'.$cat["name"];

	//рейтинг категории
	if (! empty($cat["rating"]))
	{
		echo $cat["rating"];
	}
	echo '</div>';

	//изображения категории
	if (! empty($cat["img"]))
	{
		echo '<div class="files_cat_img">';
		foreach ($cat["img"] as $img)
		{
			switch($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$cat_id.'files]">';
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

	//краткое описание категории
	if (! empty($cat["anons"]))
	{
		echo '<div class="files_cat_anons">'.$cat['anons'].'</div>';
	}

	//подкатегории
	if (! empty($cat["children"]))
	{
		foreach ($cat["children"] as $child)
		{
			echo '<div class="files_cat_link">';

			//изображения подкатегории
			if (! empty($child["img"]))
			{
				echo '<div class="files_cat_img">';
				foreach ($child["img"] as $img)
				{
					switch($img["type"])
					{
						case 'animation':
							echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$child["id"].'files]">';
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

			//название и ссылка подкатегории
			echo '<a href="'.BASE_PATH_HREF.$child["link"].'">'.$child["name"].'</a>';

			//рейтинг подкатегории
			if (! empty($child["rating"]))
			{
				echo $child["rating"];
			}

			//краткое описание подкатегории
			if (! empty($child["anons"]))
			{
				echo '<div class="files_cat_anons">'.$child['anons'].'</div>';
			}
			//файлы подкатегории
			if (! empty($child["rows"]))
			{
				foreach ($child["rows"] as $row)
				{
					echo '<div class="files">';
			
					//название и ссылка файла
					echo '<div class="files_name"><a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a>';
					//рейтинг файла
					if (! empty($row["rating"]))
					{
						echo ' '.$row["rating"];
					}
					echo '</div>';
			
					//изображения файла
					if (! empty($row["img"]))
					{
						echo '<div class="files_img">';
						foreach ($row["img"] as $img)
						{
							switch($img["type"])
							{
								case 'animation':
									echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'files]">';
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
			
					//краткое описание файла
					if (! empty($row["anons"]))
					{
						echo '<div class="files_anons">'.$row['anons'].'</div>';
					}

					//теги файла
					if (! empty($row["tags"]))
					{
						echo $row["tags"];
					}

					echo '</div>';
				}				
			}
			echo '</div>';
		}
	}

	//файлы в категории
	if ($cat["rows"])
	{
		foreach ($cat["rows"] as $row)
		{
			echo '<div class="files">';

			//изображения файла
			if (! empty($row["img"]))
			{
				echo '<div class="files_img">';
				foreach ($row["img"] as $img)
				{
					switch($img["type"])
					{
						case 'animation':
							echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'files]">';
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

			//название и ссылка файла
			echo '<div class="files_name"><a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a>';

			//рейтинг файла
			if (! empty($row["rating"]))
			{
				echo ' '.$row["rating"];
			}
			echo '</div>';

			//краткое описание файла
			if (! empty($row["anons"]))
			{
				echo '<div class="files_anons">'.$row['anons'].'</div>';
			}

			//теги файла
			if (! empty($row["tags"]))
			{
				echo $row["tags"];
			}
			echo '</div>';
		}
	}

	//ссылка на все файлы в категории
	if ($cat["link_all"])
	{
		echo '<div class="show_all"><a href="'.BASE_PATH_HREF.$cat["link_all"].'">'
		.$this->diafan->_('Посмотреть все файлы в категории «%s»', true, $cat["name"])
		.'</a></div>';
	}
	echo '</div>';
}

//постраничная навигация
if (!empty($result["paginator"]))
{
	echo $result["paginator"];
}