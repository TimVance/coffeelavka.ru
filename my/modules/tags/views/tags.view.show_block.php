<?php
/**
 * Шаблон облака тегов
 *
 * Шаблонный тег <insert name="show_block" module="tags" [template="шаблон"]>:
 * облако тегов
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

if (! $result["rows"])
	return false;

echo '<div class="tags_block">';

if (! $result["title_no_show"])
{
	echo '<div class="block_header">'.$this->diafan->_('Теги').'</div>';
}

foreach ($result["rows"] as $row)
{
	if (! empty($row["img"]))
	{
		foreach ($row["img"] as $img)
		{
			switch($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'tags]">';
					break;
				case 'large_image':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
					break;
				default:
					echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
					break;
			}
			echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
			.'</a>';
		}
	}
	if (! $row["selected"])
	{
		echo '
		<a href="'.BASE_PATH_HREF.$row["link"].'" style="font-size: '.$row["size"].'em;">'.$row["name"].'</a> ';
	}
	else
	{
		echo '
		<span style="font-size: '.$row["size"].'em;">'.$row["name"].'</span> ';
	}
}

echo '</div>';