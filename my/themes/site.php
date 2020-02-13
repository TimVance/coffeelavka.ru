<?php
/**
 * Основной шаблон сайта
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

if(! defined("DIAFAN"))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}
?><!doctype html>
<html>
<head>
	<insert name="show_include" file="head">
</head>
<body>
	<div class="main">
		<insert name="show_include" file="header">

		<div class="container">
			<insert name="show_breadcrumb">
		</div>

		<div class="content">
			<div class="container 555">
				<insert name="show_body">
			</div>
		</div>

	<insert name="show_include" file="footer">