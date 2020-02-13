<?php
/**
 * Шаблон блока похожих файлов
 * 
 * Шаблонный тег <insert name="show_block_rel" module="files" [count="количество"]
 * [images="количество_изображений"] [images_variation="тег_размера_изображений"]
 * [template="шаблон"]>:
 * блок похожих файлов
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
echo '<div class="block_header">'.$this->diafan->_('Похожие файлы').'</div>';
echo '<div class="files_block_rel">';

//заголовок блока
if (! empty($result["name"]))
{
	echo '<div class="block_header">'.$result["name"].'</div>';
}

//фaйлы
foreach ($result["rows"] as $row)
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

echo '</div>';