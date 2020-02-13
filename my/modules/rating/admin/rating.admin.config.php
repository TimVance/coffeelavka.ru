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
 * Rating_admin_config
 */
class Rating_admin_config extends Frame_admin
{
	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'config' => array (
			'only_user' => array(
				'type' => 'checkbox',
				'name' => 'Только для зарегистрированных пользователей',
				'help' => 'Параметр позволяет запретить неавторизованным пользователям голосовать.',
			),
			'security' => array(
				'type' => 'select',
				'name' => 'Защита от накруток',
				'select' => array(
					0 => 'нет',
					3 => 'вести лог голосовавших',
					4 => 'запрещать голосовать повторно',
				),
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