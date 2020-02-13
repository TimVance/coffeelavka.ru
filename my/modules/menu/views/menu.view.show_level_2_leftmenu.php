<?php
/**
 * Шаблон вывода второго и последующих уровней меню, оформленного шаблоном
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

if (empty($result["rows"][$result["parent_id"]]))
{
	return true;
}

// начало уровня меню
echo '<ul class="list-group left_menu_level_'.$result["level"].'">';
foreach ($result["rows"][$result["parent_id"]] as $row)
{
	if (!$result["rows"][$result["parent_id"]][0] != $row)
	{
	// разделитель пунктов меню
	}

	if ($row["active"])
	{
	// начало пункта меню для текущей страницы
	echo '<li class="list-group-item menu_item_'.$result["level"].' actives">';
	}
	elseif ($row["active_child"])
	{
	// начало пункта меню для активного дочернего пункта
	echo '<li class="list-group-item menu_item_'.$result["level"].' menu_active">';
	}
	else
	{
	// начало любого другого пункта меню
	echo '<li class="list-group-item menu_item_'.$result["level"].' menu_active_child">';
	}

	if (
		// на текущей странице нет ссылки, если не включена настройка "Текущий пункт как ссылка"
		(!$row["active"] || $result["current_link"])

		// влючен пункт "Не отображать ссылку на элемент, если он имеет дочерние пункты"
		&& (!$result["hide_parent_link"] || empty($result["rows"][$row["id"]]))
	)
	{
	if ($row["othurl"])
	{
		echo '<a href="'.$row["othurl"].'"'.$row["attributes"].'>';
	}
	else
	{
		echo '<a href="'.BASE_PATH_HREF.$row["link"].'"'.$row["attributes"].'>';
	}
	}

	//вывод изображения
	if (! empty($row["img"]))
	{
		echo '<img src="'.$row["img"]["src"].'" width="'.$row["img"]["width"].'" height="'.$row["img"]["height"]
		.'" alt="'.$row["img"]["alt"].'" title="'.$row["img"]["title"].'"> ';
	}

	// название пункта меню
	if (! empty($row["name"]))
	{
	    echo $row["name"];
	}

	if (
		// на текущей странице нет ссылки, если не включена настройка "Текущий пункт как ссылка"
		(!$row["active"] || $result["current_link"])

		// влючен пункт "Не отображать ссылку на элемент, если он имеет дочерние пункты"
		&& (!$result["hide_parent_link"] || empty($result["rows"][$row["id"]]))
	)
	{
	echo '</a>';
	}

	if ($result["show_all_level"] || $row["active_child"] || $row["active"])
	{
	// вывод вложенного уровня меню
	$menu_data = $result;
	$menu_data["parent_id"] = $row["id"];
	$menu_data["level"]++;

	if (empty($result['attributes']['count_level']) || $result['attributes']['count_level'] >= $menu_data["level"])
		echo $this->get('show_level_2', 'menu', $menu_data);  //вызывает сама себя, для вывод последующих уровней вложенности с классом class="menu_item_2 и т.д.
	}

	if ($row["active"])
	{
	// окончание пункта меню - текущей страницы
	echo '</li>';
	}
	elseif ($row["active_child"])
	{
	// окончание пункта меню для активного дочернего пункта
	echo '</li>';
	}
	else
	{
	// окончание любого другого пункта меню
	echo '</li>';
	}
}
// окончание уровня меню
echo '</ul>';