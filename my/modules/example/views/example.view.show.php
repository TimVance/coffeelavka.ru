<?php
/**
 * Шаблон модуля
 * 
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://cms.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2014 OOO «Диафан» (http://diafan.ru)
 */

if (! defined('DIAFAN'))
{
	include dirname(dirname(dirname(__FILE__))).'/includes/404.php';
}

foreach($result["rows"] as $row)
{
	echo '<div class="example-text">'.$row['text'].'</div>';
	//var_dump($row);
	
}
//echo "dfgdgdfg";
echo "<pre>";
foreach($result["rows333"] as $row)
{
//var_dump($result['name1']);
var_dump($row['name1']);
}
echo "</pre>";