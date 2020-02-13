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
	echo '<div class="faq_list">';

	//название категории
	echo '<div class="block_header">'.$cat["name"];

	//рейтинг категории
	if (! empty($cat["rating"]))
	{
		echo $cat["rating"];
	}
	echo '</div>';

	//краткое описание категории
	if (! empty($cat["anons"]))
	{
		echo '<div class="faq_cat_anons">'.$cat['anons'].'</div>';
	}

	//подкатегории
	if (! empty($cat["children"]))
	{
		foreach ($cat["children"] as $child)
		{
			echo '<div class="faq_cat_link">';

			//название и ссылка подкатегории
			echo '<a href="'.BASE_PATH_HREF.$child["link"].'">'.$child["name"].'</a></div>';

			//рейтинг подкатегории
			if (! empty($child["rating"]))
			{
				echo $child["rating"];
			}

			//краткое описание подкатегории
			if (! empty($child["anons"]))
			{
				echo '<div class="faq_cat_anons">'.$child['anons'].'</div>';
			}
			//вопросы подкатегории
			if (! empty($child["rows"]))
			{
				foreach ($child["rows"] as $row)
				{
					echo '<div class="faq block">';				
		
					//вопрос и ссылка на полную версию
					echo '<div class="faq_question faq-question">';
						echo '<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row['anons'].'</a>';
			
						//рейтинг вопроса
						if (! empty($row["rating"])) echo ' ' .$row["rating"];
					echo '</div>';

					//дата вопроса
					if (! empty($row['date']))
					{
						echo '<div class="faq_date">'.$row["date"]."</div>";
					}
			
					//ответ
					echo '<div class="faq_answer faq-answer">'.$row['text'].'</div>';

					//теги вопроса
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

	//вопросы в категории
	if ($cat["rows"])
	{
		foreach ($cat["rows"] as $row)
		{
			echo '<div class="faq block">';				
		
			//вопрос и ссылка на полную версию
			echo '<div class="faq_question faq-question">';
				echo '<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row['anons'].'</a>';
	
				//рейтинг вопроса
				if (! empty($row["rating"])) echo ' ' .$row["rating"];
			echo '</div>';

			//дата вопроса
			if (! empty($row['date']))
			{
				echo '<div class="faq_date">'.$row["date"]."</div>";
			}
	
			//ответ
			echo '<div class="faq_answer faq-answer">'.$row['text'].'</div>';

			//теги вопроса
			if (! empty($row["tags"]))
			{
				echo $row["tags"];
			}
	
			echo '</div>';
		}
	}
	//ссылка на все вопросы в категории
	if ($cat["link_all"])
	{
		echo '<div class="show_all"><a href="'.BASE_PATH_HREF.$cat["link_all"].'">'
		.$this->diafan->_('Посмотреть все вопросы в категории «%s»', true, $cat["name"])
		.'</a></div>';
	}
	echo '</div>';
}

//постраничная навигация
if (!empty($result["paginator"]))
{
	echo $result["paginator"];
}

//форма добавления вопроса
if (! empty($result["form"]))
{
	echo $this->get('form', 'faq', $result["form"]);
}
