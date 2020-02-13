<?php
/**
 * Настройки модуля
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

class Example_admin_config extends Frame_admin
{
	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'config' => array (
			'nastr' => array(
				'type' => 'numtext',
				'name' => 'Количество элементов на странице',
				'help' => 'Количество одновременно выводимых элементов в списке.',
			),
		)
	);

	/**
	 * @var array настройки модуля
	 */
	public $config = array (
		'config', // файл настроек модуля
	);

	/**
	 * @var array значения списков
	 */
	public $select_arr = array(
		'format_date' => array(
			0 => '01.05.2014',
			6 => '01.05.2014 14:45',
			1 => '1 мая 2014 г.',
			2 => '1 мая',
			3 => '1 мая 2014, понедельник',
			5 => 'вчера 15:30',
			4 => 'не отображать',
		),
	);
}