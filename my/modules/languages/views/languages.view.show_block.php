<?php
/**
 * Шаблон ссылок на языковые версии сайта
 *
 * Шаблонный тег <insert name="show_block" module="languages" id="номер_страницы" [template="шаблон"]>:
 * выводит блок ссылок на альтернативные языковые версии сайта
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

echo '<div class="lang-container">';
foreach ($result as $row)
{
	if($row["current"])
	{
		echo '<a href="#" class="lang active">' . $row["name"] . '</a>';		
	}
	else
	{
		echo '<a href="'.$row["link"].'" class="lang">'.$row["name"].'</a>';
	}
	echo ' ';
}
echo '</div>';