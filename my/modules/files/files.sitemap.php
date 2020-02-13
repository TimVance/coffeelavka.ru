<?php
/**
 * Карта ссылок для модуля «Карта сайта»
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
 * Files_sitemap
 */
class Files_sitemap extends Diafan
{
	/**
	 * Возвращает настройки для генерирования карты модуля
	 * 
	 * @param integer $site_id номер страницы сайта
	 * @return array
	 */
	public function config($site_id)
	{
		$result = array(
			'type' => array('element'),
			'where' =>
			array(
				'element' => ($site_id ? "AND site_id=".$site_id : '')." AND map_no_show='0' AND access='0'"
			)
		);
		if ($this->diafan->configmodules("cat", 'files', $site_id))
		{
			$result["type"][] = 'cate';
			$result["where"]['cat'] = ($site_id ? "AND site_id=".$site_id : '')." AND map_no_show='0' AND access='0'";
		}
		return $result;
	}
}