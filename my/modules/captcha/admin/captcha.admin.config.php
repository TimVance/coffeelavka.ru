<?php
/**
 * Настройки модуля
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

/**
 * Captcha_admin_config
 */
class Captcha_admin_config extends Frame_admin
{
	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'config' => array (
			'type' => array(
				'type' => 'select',
				'name' => 'Тип',
				'help' => 'Выбор метода фильтрации спам-ботов.',
				'select' => array(
					'captcha' => 'Код на картинке',
					'reCAPTCHA' => 'reCAPTCHA',
					'qa' => 'Вопрос-Ответ',
				),
			),
			'recaptcha_public_key' => array(
				'type' => 'text',
				'name' => 'Public Key для сервиса <a href="http://www.google.com/recaptcha">reCAPTCHA</a>',
				'help' => 'Параметр выводится, если в поле «Тип» выбрано «reCAPTCHA».',
			),
			'recaptcha_private_key' => array(
				'type' => 'text',
				'name' => 'Private Key для сервиса <a href="http://www.google.com/recaptcha">reCAPTCHA</a>',
				'help' => 'Параметр выводится, если в поле «Тип» выбрано «reCAPTCHA».',
			),
		),
	);

	/**
	 * @var array настройки модуля
	 */
	public $config = array (
		'config', // файл настроек модуля
	);
}