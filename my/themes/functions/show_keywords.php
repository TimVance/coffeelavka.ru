<?php
/**
 * Шаблонный тег: выводит ключевые слова страницы. Используется для мета-тега keywords.
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

if(! $this->diafan->_site->keywords && $this->diafan->configmodules('keywords_tpl', 'site'))
{
	if($this->diafan->_site->parent_id && ! $this->diafan->_site->parent_name
	   && strpos($this->diafan->configmodules("keywords_tpl", 'site'), '%parent') !== false)
	{
		$this->diafan->_site->parent_name = DB::query_result("SELECT [name] FROM {site} WHERE id=%d", $this->diafan->_site->parent_id);
	}
	$this->diafan->_site->keywords = str_replace(
		array('%name', '%parent'),
		array($this->diafan->_site->name, $this->diafan->_site->parent_name),
		$this->diafan->configmodules("keywords_tpl", 'site')
	);
}
echo str_replace('"', '&quot;', $this->diafan->_site->keywords);