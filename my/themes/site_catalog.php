<?php
/**
 * Шаблон страницы каталога
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
	<div class="main nopasaran">
		<insert name="show_include" file="header">
			<div class="container">
				<insert name="show_breadcrumb">
			</div>
		<div class="content">
			<div class="container 556">
				<div class="row">
					<div class="col-md-3 hidden-xs">
						<insert name="show_block" module="menu" template="leftmenu" id="3">
						<br>
						<insert name="show_search" module="shop" cat_id="all">
					</div>

					<div class="col-md-9">
						<insert name="show_body">
					</div>
				</div>
			</div>
		</div>

	<insert name="show_include" file="footer">