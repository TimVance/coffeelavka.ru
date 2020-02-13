<?php
/**
 * Настройки для поисковой индексации для модуля «Поиск»
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
 * Faq_search_config
 */
class Faq_search_config
{
	public $config = array(
		'faq' => array(
			'fields' => array('anons', 'text'),
			'rating' => 6
		),
		'faq_category' => array(
			'fields' => array('name', 'anons', 'text'),
			'rating' => 6
		)
	);
}