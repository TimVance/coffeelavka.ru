<?php
/**
 * Генерирование изображения капчи
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

if($this->diafan->configmodules('type', 'captcha') == 'qa' || $this->diafan->configmodules('type', 'captcha') == 'reCAPTCHA')
{
	Custom::inc('includes/404.php');
}

Custom::inc('plugins/kcaptcha/kcaptcha.php');

$chaptcha = new KCAPTCHA();

$_SESSION["captcha"][substr($_GET["rewrite"], 0, -4)][substr($_GET["rewrite"], -4)] = $chaptcha->getKeyString();

exit;