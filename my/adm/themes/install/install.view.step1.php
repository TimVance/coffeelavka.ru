<?php
/**
 * Шаблон контентной области первого шага установки DIAFAN.CMS
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

$disabled = false;
?><div class="box box_install">
<div class="list-item"><?php
	if (phpversion() < '5.2')
	{
		echo '<i class="fa fa-times-circle" style="color: #ed1c24"></i>';
		$disabled = true;
	}
	else
	{
		echo '<i class="fa fa-check-circle" style="color: #acd373"></i>';
	}
	?>
	Версия PHP > 5.2
</div>
<div class="list-item">
	<?php
	if (! function_exists('mysql_connect') && ! function_exists('mysqli_connect'))
	{
		echo '<i class="fa fa-times-circle" style="color: #ed1c24"></i>';
		$disabled = true;
	}
	else
	{
		echo '<i class="fa fa-check-circle" style="color: #acd373"></i>';
	}
	?>
	Поддержка MySQL
</div>
<div class="list-item">
	<?php
	$fp = @fsockopen('diafan.ru', 80);
	if (! $fp)
	{
		echo '<i class="fa fa-times-circle" style="color: #ed1c24"></i>';
		$disabled = true;
	}
	else
	{
		echo '<i class="fa fa-check-circle" style="color: #acd373"></i>';
	}
	?>
	Поддержка сокетов
</div>
<?php $folders = array('userfiles', 'cache', 'tmp', 'custom', 'return');
foreach($folders as $f)
{
	echo '<div class="list-item">';
	if (File::is_writable($f))
	{
		echo '<i class="fa fa-check-circle" style="color: #acd373"></i>';
	}
	else
	{
		echo '<i class="fa fa-times-circle" style="color: #ed1c24"></i>';
		$disabled = true;
	}
	echo ' Папка /'.$f.'/</div>';
}
?>
<?php $files = array('install.php', 'config.php', 'index.html');
foreach($files as $f)
{
	echo '<div class="list-item">';
	if (File::is_writable($f))
	{
		echo '<i class="fa fa-check-circle" style="color: #acd373"></i>';
	}
	else
	{
		echo '<i class="fa fa-times-circle" style="color: #ed1c24"></i>';
		$disabled = true;
	}
	echo ' Файл '.$f.'</div>';
}
?>
<?php if ($disabled)
{ ?>
	<div class="list-item">
		<b>Установка CMS будет успешной после того, как будут устранены несоответствия.</b>
	</div>
<?php
} ?>

<span class="btn btn_blue" onclick="window.location=window.location">
	<i class="fa fa-refresh"></i>
	Проверить снова
</span>
&nbsp;
<span class="btn <?php if ($disabled){ echo " btn_disable"; } else { echo '" onclick="window.location=\''.BASE_PATH.'installation/step2/\'';} ?>">
	Далее
</span>
</div>