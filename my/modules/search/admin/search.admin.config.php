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
 * Search_admin_config
 */
class Search_admin_config extends Frame_admin
{
	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'config'       => array (
			'nastr' => array(
				'type' => 'numtext',
				'name' => 'Количество результатов на странице',
				'help' => 'Количество одновременно выводимых результатов поиска в списке.',
			),
			'count_history' => array(
				'type' => 'numtext',
				'name' => 'Количество последних запросов в истории поиска',
			),
			'search_all_word' => array(
				'type' => 'checkbox',
				'name' => 'Искать все слова сразу',
				'help' => 'Если не отмечено, ищет хотя бы одно слово.',
			),
			'search_like' => array(
				'type' => 'checkbox',
				'name' => 'Искать часть слова',
				'help' => 'Если не отмечено, ищет слово и словоформы целиком. Если отмечено, то может найти длинное слово уже по первым трем-четырем символам. Если отмечено, то настройка «Искать все слова сразу» не работает.',
			),
			'max_length' => array(
				'type' => 'numtext',
				'name' => 'Минимальная длина слова',
				'help' => 'При изменении параметра необходимо переиндексировать весь сайт. Чем меньше этот параметр, тем больше места занимает поисковый индекс. Значение по умолчанию: 3.',
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