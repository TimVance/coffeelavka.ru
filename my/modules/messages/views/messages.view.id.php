<?php
/**
 * Шаблон переписки с пользователем
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

echo '<table class="messages">';
foreach ($result['rows'] as $row)
{
	echo '<tr><td class="messages_avatar">';
	if (!empty($row['name']['avatar']))
	{
		echo '<img src="'.$row["name"]["avatar"].'" width="'.$row["name"]["avatar_width"].'" height="'.$row["name"]["avatar_height"].'" alt="'.$row["name"]["fio"].' ('.$row["name"]["name"].')" class="avatar">';
	}
	$user = $row['name']['fio'].' ('.$row['name']['name'].')';
	if(!empty($row['name']['user_page']))
	{
		$user='<a href="'.$row['name']['user_page'].'">'.$user.'</a>';
	}
	echo '
	</td>
	<td class="messages_user">
		<div><div>'.$user.'</div>'.$row['created'].'</div>
	</td>
	<td class="messages_text">'.$row['text'].'</td>
	</tr>';
}
echo '</table>';

echo $this->get('get', 'paginator', $result['paginator']); 

echo $this->get('form', 'messages', array("to" => $this->diafan->_route->show, "redirect" => 1));