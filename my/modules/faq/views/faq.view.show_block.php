<?php
/**
 * Шаблон блока вопросов и ответов
 * 
 * Шаблонный тег <insert name="show_block" module="faq" [count="количество"]
 * [cat_id="категория"] [site_id="страница_с_прикрепленным_модулем"]
 * [sort="порядок_вывода"] [often="часто_задаваемые_вопросы"]
 * [only_module="только_на_странице_модуля"] [template="шаблон"]>:
 * блок вопросов и ответов
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


//заголовок блока
if (! empty($result["name"]))
{
	echo '<h2>'.$result["name"].'</h2>';
}

echo '<div class="block">';

//вопросы
foreach ($result["rows"] as $row)
{
	echo '<div class="faq block-row">';
	
	//вопрос
	echo '<div class="faq_question faq-question">';
	if($row["link"])
	{
		echo '<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row['anons'].'</a>';
	}
	else
	{
		echo $row["anons"];
	}
	echo '</div>';

	//дата вопроса
	if (! empty($row["date"]))
	{
		echo '<div class="date">'.$row["date"].'</div>';
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

echo '</div>';