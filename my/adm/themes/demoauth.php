<?php
/**
 * Шаблон формы авторизации для демо-сайта
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
include_once(ABSOLUTE_PATH.'adm/brand.php');
?>

<html>

<head>
<meta charset="UTF-8">
<title>Демо-версия DIAFAN.CMS</title>
<meta name="HandheldFriendly" content="True">
<meta name="viewport" content="width=device-width, initial-scale=-0.2, minimum-scale=-0.2, maximum-scale=3.0">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="pragma" content="no-cache">

<link href="<?php echo BASE_PATH;?>adm/css/main.css" rel="stylesheet" type="text/css"></head>

<!--[if lte IE 8]>
	<link rel="stylesheet" href="<?php echo BASE_PATH;?>adm/css/ie/ie.css" media="all" />
<![endif]-->


<body>

<body class="login-page">
	<div id="wrapper">
		<!-- |===============| header start |===============| -->
		<header class="header">
			<a href="http://<?php echo BASE_URL?>/" class="logo">
				<img src="<?php echo BASE_PATH; ?>adm/img/logo.png" alt="">
				<span class="logo__title">Система управления</span>
				<span class="logo__link"><?php echo BASE_URL?></span>
			</a>
			
		</header>
		<!-- |===============| header end |===============| -->
		
		<!-- |===============| wrap start |===============| -->
		<div class="wrap">
				<form name="auth" method="post" action="http<?php echo (IS_HTTPS ? "s" : ''); ?>://<?php echo BASE_URL;?>/admin/" action="" class="login-form">
						<input type="hidden" name="create" value="1">
						<p>Ваш персональный демонстрационный сайт будет создан после того, как Вы нажмете «Создать демо-сайт». Вам доступны большинство действий из полной версии <a href="http://www.diafan.ru/" target="_blank">DIAFAN.CMS</a><br>
Демо-сайт будет существовать до тех пор, 
пока открыто окно Вашего браузера.<br>
						<span class="color_gray">(Рекомендуем видеоурок <a href="http://www.diafan.ru/videouroki/urok5/" target="_blank">Знакомство с DIAFAN.CMS</a>).</span>
						</p>
						<p><b>Внимание!</b> Создание временных данных для демо-сайта (таблицы БД и файлы) занимает время от 15 до 90 секунд.</p>
						
						<button class="btn btn_blue btn_small">
							<i class="fa fa-lock"></i>
							Создать демо-сайт
						</button>
					</form>
		</div>
		<!-- |===============| wrap end |===============| -->
		
	</div>
</body>
</html>
