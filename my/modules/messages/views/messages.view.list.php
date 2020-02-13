<?php
/**
 * Шаблон списка контактов
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

if (empty($result['rows']))
{
	echo $this->diafan->_('У Вас нет ни одного контакта. Чтобы вести приватную переписку с пользователем нужно на странице пользователя выбрать «Напишите сообщение».');
	return false;
}

echo '<table class="messages">';
foreach ($result['rows'] as $row)
{

	$user = $row['user']['fio'].' ('.$row['user']['name'].')';
	if(!empty($row['user']['user_page']))
	{
		$user = '<a href="'.$row['user']['user_page'].'">'.$user.'</a>';
	}
	$user .= '<br>'.$row['last_message']['created'];
	
	echo '<tr><td class="messages_avatar">';
	if (!empty($row['user']['avatar']))
	{
		echo '<img src="'.$row["user"]["avatar"].'" width="'.$row["user"]["avatar_width"].'" height="'.$row["user"]["avatar_height"].'" alt="'.$row["user"]["fio"].' ('.$row["user"]["name"].')" class="avatar">';
	}
	echo '</td>
	<td class="messages_user">'.$user.'</td>
	<td class="messages_text"><a href="'.$row['link'].'">'.$row['last_message']['text'].'</a></td>
	</tr>';
}
echo '</table>';