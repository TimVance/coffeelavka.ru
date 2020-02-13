<?php
/**
 * Шаблон страницы файла
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

echo '<div class="files_id">';

//описание файла
echo '<div class="files_text">'.$result['text'].'</div>';

//изображения файла
if (! empty($result["img"]))
{
	echo '<div class="files_all_img">';
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

//счетчик просмотров
if(! empty($result["counter"]))
{
	echo '<div class="files_counter">'.$this->diafan->_('Просмотров').': '.$result["counter"].'</div>';
}

//теги файла
if (! empty($result["tags"]))
{
	echo $result["tags"];
}

//ссылка на скачивание файла
if (! empty($result["files"]))
{
	foreach ($result["files"] as $f)
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

//рейтинг файла
if (! empty($result["rating"]))
{
	echo $result["rating"];
}

//комментарии к файлу
if (! empty($result["comments"]))
{
	echo $result["comments"];
}

//ссылки на предыдущий и последующий файл
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

echo '</div>';

echo $this->htmleditor('<insert name="show_block_rel" module="files" count="4" images="1">');