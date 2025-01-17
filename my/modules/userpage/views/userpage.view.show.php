<?php
/**
 * Шаблон страницы пользователя
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

echo '<div class="user_page">';
// if (!empty($result['avatar']))
// {
// 	echo '<img src="'.BASE_PATH.USERFILES.'/avatar/'.$result["name"].'.png" width="'.$result["avatar_width"].'" height="'.$result["avatar_height"].'" alt="'.$result["fio"].' ('.$result["name"].')" class="avatar">';
// }
echo '<p>'.$result['fio'].' ('.$result['name'].')<p>'.$this->diafan->_('Дата регистрации').': '.$result['created'];
if(isset($result["balance"]))
{
	echo '<p>'.$this->diafan->_('Сумма на балансе').': '.$result['balance']["summ"].' '.$result['balance']["currency"];
	if(! empty($result["balance"]["link"]))
	{
		echo '<p><a class="btn btn-warning btn-sm" href="'.BASE_PATH_HREF.$result["balance"]["link"].'">'.$this->diafan->_('Пополнить баланс').'</a>';
	}
}

echo '';

echo '<table>';
foreach ($result['param'] as $row)
{
	if($row['type'] == 'title')
	{
		echo '<tr><td><b>'.$row['name'].'</b></td><td></td></tr>';
		continue;
	}
	if (empty($row['value']))
	{
		if($row['type'] == 'checkbox')
		{
			echo '<tr><td>'.$row['name'].'</td><td></td></tr>';
		}
		continue;
	}
	echo '<tr><td>'.$row['name'].':</td><td>';
	switch ($row['type'])
	{
		case 'select':
			echo $row['value'][0];
			break;
		case 'multiple':
			echo implode(',', $row['value']);
			break;
		case "attachments":
			foreach ($row['value'] as $a)
			{
				if ($a["is_image"])
				{
					if($row["use_animation"])
					{
						echo ' <a href="'.$a["link"].'" rel="prettyPhoto[galleryUsers]"><img src="'.$a["link_preview"].'"></a> <a href="'.$a["link"].'" rel="prettyPhoto[galleryUsers_link]">'.$a["name"].'</a>';
					}
					else
					{
						echo ' <a href="'.$a["link"].'"><img src="'.$a["link_preview"].'"></a> <a href="'.$a["link"].'">'.$a["name"].'</a>';
					}
				}
				else
				{
					echo ' <a href="'.$a["link"].'">'.$a["name"].'</a>';
				}
				echo '<br>';
			}
			break;
		case "images":
			foreach ($row["value"] as $img)
			{
				echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">';
			}
			break;
		default:
			echo $row['value'];
	}
	echo '</td></tr>';
}

echo '</table>';

if (! empty($result['form_messages']))
{
	echo $this->diafan->_tpl->get('form', 'messages', array("to" => $result['id']));
}

echo '</div>';

echo $this->diafan->_tpl->get('orders', 'userpage', $result);