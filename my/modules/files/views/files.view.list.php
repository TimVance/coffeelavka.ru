<?php
/**
 * Шаблон вывода списка файлов
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

echo '<div class="files_list">';

//описание текущей категории
if (! empty($result["text"]))
{
	echo '<div class="files_cat_text">'.$result['text'].'</div>';
}

//рейтинг категории
if (! empty($result["rating"]))
{
	echo $result["rating"];
}

//изображения текущей категории
if (! empty($result["img"]))
{
	echo '<div class="files_cat_all_img">';
	foreach ($result["img"] as $img)
	{
		switch($img["type"])
		{
			case 'animation':
				echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$result["id"].'files]">';
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

//подкатегории
if (! empty($result["children"]))
{
	foreach ($result["children"] as $child)
	{
		echo '<div class="files_cat_link">';

		//изображение подкатегории
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
		if ($child["anons"])
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

				//ссылка на скачивание файла
				if (! empty($row["files"]))
				{
					foreach ($row["files"] as $f)
					{
						echo '<div class="files_download">';
						echo '<a href="'.$f["link"].'">'.$this->diafan->_('Скачать').'</a>';
							//имя файла
							if (! empty($f["name"])) echo ' '.$f["name"];
							//размер файла
							if (! empty($f["size"])) echo ' ('.$f["size"].')';
						echo '</div>';
					}
				}
		
				echo '</div>';
			}			
		}
		echo '</div>';
	}
}

//файлы
if (! empty($result["rows"]))
{
	foreach ($result["rows"] as $row)
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

		//ссылка на скачивание файла
		if (! empty($row["files"]))
		{
			foreach ($row["files"] as $f)
			{
				echo '<div class="files_download">';
				echo '<a href="'.$f["link"].'">'.$this->diafan->_('Скачать').'</a>';
					//имя файла
					if (! empty($f["name"])) echo ' '.$f["name"];
					//размер файла
					if (! empty($f["size"])) echo ' ('.$f["size"].')';
				echo '</div>';
			}
		}

		echo '</div>';
	}	
}

//постраничная навигация
if (! empty($result["paginator"]))
{
	echo $result["paginator"];
}

//ссылки на предыдущую и последующую категории
if (! empty($result["previous"]) || ! empty($result["next"]))
{
	echo '<div class="previous_next_links">';
	if (! empty($result["previous"]))
	{
		echo '<div class="previous_link"><a href="'.BASE_PATH_HREF.$result["previous"]["link"].'">&larr; '.$result["previous"]["text"].'</a></div>';
	}
	if (! empty($result["next"]))
	{
		echo '<div class="next_link"><a href="'.BASE_PATH_HREF.$result["next"]["link"].'">'.$result["next"]["text"].' &rarr;</a></div>';
	}
	echo '</div>';
}

//комментарии к категориям
if (! empty($result["comments"]))
{
	echo $result["comments"];
}
echo '</div>';