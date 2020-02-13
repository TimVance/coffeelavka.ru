<?php
/**
 * Шаблон блока похожих вопросов и ответов
 * 
 * Шаблонный тег <insert name="show_block_rel" module="faq" [count="количество"] [template="шаблон"]>:
 * блок похожих вопросов и ответов
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
echo '<div class="block_header">'.$this->diafan->_('Похожие вопросы').'</div>';

echo '<div class="faq_block_rel">';

//заголовок блока
if (! empty($result["name"]))
{
	echo '<div class="block_header">'.$result["name"].'</div>';
}

//вопросы
foreach ($result["rows"] as $row)
{
	echo '<div class="faq">';

	//дата вопроса
	if (! empty($row["date"]))
	{
		echo '<div class="faq_date">'.$row["date"].'</div>';
	}
	//вопрос
	echo '<div class="faq_question">';
	if($row["link"])
	{
		echo '<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row['anons'].'</a>';
	}
	else
	{
		echo $row["anons"];
	}
	echo '</div>';

	//ответ
	echo '<div class="faq_answer">'.$row['text'].'</div>';

	//теги вопроса
	if (! empty($row["tags"]))
	{
		echo $row["tags"];
	}

	echo '</div>';
}
echo '</div>';