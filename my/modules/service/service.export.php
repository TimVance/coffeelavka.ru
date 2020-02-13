<?php
/**
 * Экспорт БД
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

if(defined('IS_DEMO') && IS_DEMO)
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

/**
 * Service_export
 */

if(! $this->diafan->_users->roles("init", "service/db", array(), 'admin'))
{
	Custom::inc('includes/404.php');
}

$contant = array();
$i = 0;
$text = "-- DIAFAN.CMS part".$i."\n-- Datetime: ".date('Y-m-d H:i:s')."\n-- Site: ".BASE_PATH."\n\n";

$max = 838860;

$url = parse_url(DB_URL);
$dbname = substr($url['path'], 1);
$rows = DB::query_fetch_all("SHOW TABLES FROM `".$dbname."`");
foreach ($rows as $row)
{
	if (preg_match('/^'.preg_quote(DB_PREFIX, '/').'/', $row["Tables_in_".$dbname]))
	{
		// структура
		$row_s = DB::query_fetch_array("SHOW CREATE TABLE `".$row["Tables_in_".$dbname]."`");
		$text .= "DROP TABLE IF EXISTS `".$row["Tables_in_".$dbname]."`;\n".$row_s["Create Table"].";\n\n";
		check_size($text, $contant, $i);

		// данные
		$exsql = '';
		$rows_d = DB::query_fetch_all("SELECT * FROM `".$row["Tables_in_".$dbname]."`");
		foreach ($rows_d as $row_d)
		{
			$values = '';
			foreach ($row_d as $v)
			{
				$values .= $values ? ',' : '';
				if (is_null($v))
				{
					$values .= "NULL";
				}
				else
				{
					$values .= "'".DB::escape_string($v)."'";
				}
			}
			$exsql .= ($exsql ? ',' : '')."(".$values.")";
			if (strlen($exsql) > $max)
			{
				$text .= "INSERT INTO `".$row["Tables_in_".$dbname]."` VALUES ".$exsql.";\n";
				check_size($text, $contant, $i);
				$exsql = '';
			}
		}
		if ($exsql)
		{
			$text .= "INSERT INTO `".$row["Tables_in_".$dbname]."` VALUES ".$exsql.";\n";
			check_size($text, $contant, $i);
		}
	}
}
$text .= "\n-- DIAFAN.CMS dump end\n";
$contant[] = $text;

$is_zip = false;
if(class_exists('ZipArchive'))
{
	$name = ABSOLUTE_PATH.'tmp/'.md5(mt_rand(0, 9999)).'.zip';
	$zip = new ZipArchive;
	if ($zip->open($name, ZipArchive::CREATE) === true)
	{
		foreach ($contant as $i => $text)
		{
			$zip->addFromString(DB_PREFIX."db".$i.".sql", $text);
		}
		$zip->close();
		$text = file_get_contents($name);
		unlink($name);
		$is_zip = true;
	}
}

header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: max-age=86400');
if($is_zip)
{
	header("Content-type: application/zip");
	header("Content-Disposition: attachment; filename=".DB_PREFIX."db.sql.zip");
}
else
{
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=".DB_PREFIX."db.sql");
}
header('Content-transfer-encoding: binary');
header("Connection: close");

if($is_zip)
{
	echo $text;
}
else
{
	echo implode("\n", $contant);
}

function check_size(&$text, &$contant, &$i)
{
	if(strlen($text) > 524288) // 1МБ
	{
		$i++;
		$contant[] = $text;
		$text = "-- DIAFAN.CMS part".$i."\n-- Datetime: ".date('Y-m-d H:i:s')."\n-- Site: ".BASE_PATH."\n\n";
	}
}
exit;