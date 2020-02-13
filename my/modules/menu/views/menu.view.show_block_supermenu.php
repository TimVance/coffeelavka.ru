<?php
/**
 * Шаблон вывода первого уровня меню, вызывается из функции show_block в начале файла, оформленного шаблоном
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
//"<div id='prod_left'>";
// начало уровня ме
//echo "<pre>";
//var_dump($result["rows"]);
//echo "</pre>";
foreach ($result["rows"] as $row)
{
}
		//echo '<div class="content">';
			//echo '<div class="container">';
echo '<div id="cat_prod">';
echo '<div id="prod_left">';
		if($row["0"]["id"] == "195") {
		//coffe
		//var_dump($row["0"]);
		echo '<div id="coffe">';
		echo '<a href="'.$row["0"]["link"].'"'.$row["attributes"].'>';
		echo '<img src="'.$row["0"]["img"]["src"].'"> ';
	    echo '<span>' .$row["0"]["name"] . '</span>';
		echo '</a>';
		echo '</div>';
		}
		else {
				echo "";
		}
		if($row["3"]["id"] ==  "208") {
		//list
		echo '<div id="tea_list">';
		echo '<a href="'.$row["3"]["link"].'"'.$row["attributes"].'>';
		echo '<img src="'.$row["3"]["img"]["src"].'"> ';
	    echo '<span>' .$row["3"]["name"] . '</span>';
		echo '</a>';
		echo '</div>';
			}
		else {
				echo "";
		}
echo "</div>";
echo '<div id="prod_right">';
	echo '<div class="line1">';
				//oborud
		if($row["5"]["id"] == "210") {
				echo '<div id="oborud">';
				echo '<a href="'.$row["5"]["link"].'">';
				echo '<img src="'.$row["5"]["img"]["src"].'"> ';
			    echo '<span>' .$row["5"]["name"] . '</span>';
				echo '</a>';
				echo '</div>';
			}
		else {
				echo "";
		}

		//chock
		if($row["2"]["id"] == "198") {
				echo '<div id="chock">';
				echo '<a href="'.$row["2"]["link"].'"'.$row["attributes"].'>';
				echo '<img src="'.$row["2"]["img"]["src"].'" width="'.$row["img"]["width"].'" height="'.$row["img"]["height"]
				.'" alt="'.$row["img"]["alt"].'" title="'.$row["img"]["title"].'"> ';
			    echo '<span>' .$row["2"]["name"] . '</span>';
				echo '</a>';
				echo '</div>';
		}
		else {
				echo "";
		}
		//matcha
		if($row["1"]["id"] == "197") {
				echo '<div id="matcha">';
				echo '<a href="'.$row["1"]["link"].'"'.$row["attributes"].'>';
				echo '<img src="'.$row["1"]["img"]["src"].'" width="'.$row["img"]["width"].'" height="'.$row["img"]["height"]
				.'" alt="'.$row["img"]["alt"].'"> ';
			    echo '<span>' .$row["1"]["name"] . '</span>';
				echo '</a>';
				echo '</div>';
			}
		else {
				echo "";
		}
echo '</div>';
echo '<div class="line2">';
//akses
if($row["4"]["id"] == "209") {
		echo '<div id="akses">';
		echo '<a href="'.$row["4"]["link"].'"'.$row["attributes"].'>';
		echo '<img src="'.$row["4"]["img"]["src"].'" width="'.$row["img"]["width"].'" height="'.$row["img"]["height"]
		.'" alt="'.$row["img"]["alt"].'" title="'.$row["img"]["title"].'"> ';
	   echo '<span>' .$row["4"]["name"] . '</span>';
		echo '</a>';
		echo '</div>';
	}
else {
		echo "";
}
//rio	
if($row["6"]["id"] == "212") {	
		echo '<div id="rio">';
		echo '<a href="'.$row["6"]["link"].'"'.$row["attributes"].'>';
		echo '<img src="'.$row["6"]["img"]["src"].'" width="'.$row["img"]["width"].'" height="'.$row["img"]["height"]
		.'" alt="'.$row["img"]["alt"].'" title="'.$row["img"]["title"].'"> ';
	   echo '<span>' .$row["6"]["name"] . '</span>';
		echo '</a>';
		echo '</div>';
}
else {
		echo "";
}
echo '</div>';
echo '<div class="line3">';
if($row["7"]["id"] == "213") {
		//djez
		echo '<div id="djez">';
		echo '<a href="'.$row["7"]["link"].'"'.$row["attributes"].'>';
		echo '<img src="'.$row["7"]["img"]["src"].'" width="'.$row["img"]["width"].'" height="'.$row["img"]["height"]
		.'" alt="'.$row["img"]["alt"].'" title="'.$row["img"]["title"].'"> ';
	    echo '<span>' .$row["7"]["name"] . '</span>';
		echo '</a>';
		echo '</div>';
}
else {
		echo "";
}
if($row["8"]["id"] == "214") {

		//sirop
		echo '<div id="sirop">';
		echo '<a href="'.$row["8"]["link"].'"'.$row["attributes"].'>';
		echo '<img src="'.$row["8"]["img"]["src"].'" width="'.$row["img"]["width"].'" height="'.$row["img"]["height"]
		.'" alt="'.$row["img"]["alt"].'" title="'.$row["img"]["title"].'"> ';
	    echo '<span>' .$row["8"]["name"] . '</span>';
		echo '</a>';
		echo '</div>';
}
else {
		echo "";
}
echo "</div>";
echo "</div>";
echo "</div>";
//echo "</div>";
//echo "</div>";
// окончание уровня меню

//echo "<pre style='color:red;margin:40px 0;'>";
//var_dump($result["rows"]["0"]);
//echo "<pre>";
//var_dump($row);
//echo "</pre>";