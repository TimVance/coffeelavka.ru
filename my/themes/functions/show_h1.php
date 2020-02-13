<?php
/**
 * Шаблонный тег: выводит заголовок страницы, если не запрещен его вывод в настройке странице «Не показывать заголовок».
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

if (! $this->diafan->_site->title_no_show)
{
	if ($this->diafan->_site->titlemodule)
	{
		$name = $this->diafan->_site->titlemodule;
		if ($this->diafan->_site->edit_meta)
		{
			$name = $this->diafan->_useradmin->get($name, 'name', $this->diafan->_site->edit_meta["id"], $this->diafan->_site->edit_meta["table"], _LANG);
		}
	}
	else
	{
		$name = $this->diafan->_useradmin->get($this->diafan->_site->name, 'name', $this->diafan->_site->id, 'site', _LANG);
	}
	echo $name;
}