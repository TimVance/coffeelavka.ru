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
 * News_search_config
 */
class News_search_config
{
	public $config = array(
		'news' => array(
			'fields' => array('name', 'anons', 'text'),
			'rating' => 5
		),
		'news_category' => array(
			'fields' => array('name', 'anons', 'text'),
			'rating' => 5
		)
	);
}