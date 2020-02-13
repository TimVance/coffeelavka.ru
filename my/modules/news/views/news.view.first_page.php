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

if (!empty($result["categories"]))
{
	//вывод категории
	foreach ($result["categories"] as $cat_id => $cat)
	{
		echo '<div class="news_list">';

		//вывод названия категории новостей
		echo '<div class="block_header">';
		// echo '<a href="'.BASE_PATH_HREF.$cat["link_all"].'">'.$cat["name"].'</a>';

		//рейтинг категории
		if (! empty($cat["rating"]))
		{
			echo $cat["rating"];
		}
		echo '</div>';

		//вывод изображений категории
		if (! empty($cat["img"]))
		{
			echo '<div class="news_cat_img">';
			foreach ($cat["img"] as $img)
			{
				switch($img["type"])
				{
					case 'animation':
						echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$cat_id.'news]">';
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

		//вывод краткого описания категории
		if (! empty($cat["anons"]))
		{
			echo '<div class="news_cat_anons">'.$cat['anons'].'</div>';
		}

		//вывод подкатегории
		if (! empty($cat["children"]))
		{
			foreach ($cat["children"] as $child)
			{
				echo '<div class="news_cat_link">';

				//изображения подкатегории
				if (! empty($child["img"]))
				{
					echo '<div class="news_cat_img">';
					foreach ($child["img"] as $img)
					{
						switch($img["type"])
						{
							case 'animation':
								echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$child["id"].'news]">';
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
					echo '<div class="news_cat_anons">'.$child['anons'].'</div>';
				}
				//новости подкатегории
				if (! empty($child["rows"]))
				{
					foreach ($child["rows"] as $row)
					{
						echo '<div class="news block">';

						//вывод изображений новости
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
								echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
								.'</a> ';
							}
						}

						echo '<div class="block-text">';

					        //вывод названия и ссылки на новость
							echo '<h4>';
								echo '<a href="'.BASE_PATH_HREF.$row["link"].'" class="black">'.$row["name"].'</a>';
							echo '</h4>';

							//вывод рейтинга новости за названием, если рейтинг подключен
							if (! empty($row["rating"]))
							{
								echo '<div class="news_rating rate"> ' .$row["rating"] . '</div>';
							}

							//вывод анонса новостей
							if (! empty($row["anons"]))
							{
								echo '<div class="news_anons anons">'.$row['anons'].'</div>';
							}

							//вывод даты новости
							if (! empty($row['date']))
							{
								echo '<div class="news_date date">'.$row["date"]."</div>";
							}

							//вывод прикрепленных тегов к новости
							if (! empty($row["tags"]))
							{
								echo $row["tags"];
							}

							echo '</div>';

						echo '</div>';
					}
				}
				echo '</div>';
			}
		}

		//вывод нескольких новостей из категории
		if ($cat["rows"])
		{
			foreach ($cat["rows"] as $row)
			{
				echo '<div class="news block media">';
				echo '<div class="media-left">';

				//вывод изображений новости
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
								echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
								break;
						}
						echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'" class="block-row-img">'
						.'</a> ';
					}
				}

				echo '</div>';

				echo '<div class="block-text media-body">';

			        //вывод названия и ссылки на новость
					echo '<h4 class="media-heading">';
						echo '<a href="'.BASE_PATH_HREF.$row["link"].'" class="black">'.$row["name"].'</a>';
					echo '</h4>';

					//вывод рейтинга новости за названием, если рейтинг подключен
					if (! empty($row["rating"]))
					{
						echo '<div class="news_rating rate"> ' .$row["rating"] . '</div>';
					}

					//вывод анонса новостей
					if (! empty($row["anons"]))
					{
						echo '<div class="news_anons anons">'.$row['anons'].'</div>';
					}

					//вывод даты новости
					if (! empty($row['date']))
					{
						echo '<div class="news_date date">'.$row["date"]."</div>";
					}

					//вывод прикрепленных тегов к новости
					if (! empty($row["tags"]))
					{
						echo $row["tags"];
					}

				echo '</div>';

				echo '</div>';
			}
		}

			//ссылка на все новости в категории
			// if ($cat["link_all"])
			// {
			// 	echo '<div class="show_all"><a href="'.BASE_PATH_HREF.$cat["link_all"].'">'
			// 	.$this->diafan->_('Посмотреть все новости в категории «%s»', true, $cat["name"])
			// 	.'</a></div>';
			// }

		echo '</div>';
	}
}

//вывод новостей, которые не принадлежат никаким категориям
if (! empty($result["rows"]))
{
	foreach ($result["rows"] as $row)
	{
		echo '<div class="news block media">';
		echo '<div class="media-left">';

		//вывод изображений новости
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
				echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
				.'</a> ';
			}
		}

		echo '</div>';

		echo '<div class="block-text media-body">';
			 //вывод названия и ссылки на новость
			echo '<h4>';
				echo '<a href="'.BASE_PATH_HREF.$row["link"].'" class="black">'.$row["name"].'</a>';
			echo '</h4>';

			//вывод рейтинга новости за названием, если рейтинг подключен
			if (! empty($row["rating"]))
			{
				echo '<div class="news_rating rate"> ' .$row["rating"] . '</div>';
			}

			//вывод анонса новостей
			if (! empty($row["anons"]))
			{
				echo '<div class="news_anons anons">'.$row['anons'].'</div>';
			}

			//вывод даты новости
			if (! empty($row['date']))
			{
				echo '<div class="news_date date">'.$row["date"]."</div>";
			}

			//вывод прикрепленных тегов к новости
			if (! empty($row["tags"]))
			{
				echo $row["tags"];
			}

			echo '</div>';

		echo '</div>';
	}
}

//постраничная навигация
if (! empty($result["paginator"]))
{
	echo $result["paginator"];
}