<?php
/**
 * Подгрузка панели быстрого редактирования
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

class Useradmin_action extends Action
{
	/**
	 * Выводит панель быстрого редактирования
	 *
	 * @return void
	 */
	public function init()
	{
		if(IS_MOBILE)
		{
			return false;
		}				
		$link_current_edit = BASE_PATH.ADMIN_FOLDER.'/';
		if($this->diafan->_site->module && ($this->diafan->_route->cat || $this->diafan->_route->show || $this->diafan->_route->brand) && Custom::exists('modules/'.$this->diafan->_site->module.'/admin/'.$this->diafan->_site->module.'.admin.php'))
		{
			$link_current_edit .= $this->diafan->_site->module.'/';
			if($this->diafan->_route->show)
			{
				$link_current_edit .= 'edit'.$this->diafan->_route->show.'/';
			}
			elseif($this->diafan->_route->brand)
			{
				$link_current_edit .= 'brand/edit'.$this->diafan->_route->brand.'/';
			}
			else
			{
				$link_current_edit .= 'category/edit'.$this->diafan->_route->cat.'/';
			}
		}
		else
		{
			$link_current_edit .= 'site/edit'.$this->diafan->_site->id.'/';
		}
		header('Content-Type: text/html; charset=utf-8');
		
		$add_pages = array();
		$admin_pages = DB::query_fetch_all("SELECT * FROM {admin} WHERE `add`='1' AND parent_id=0 ORDER BY sort ASC");
		foreach($admin_pages as $row)
		{
			if (! $this->diafan->_users->roles('init', $row["rewrite"]))
			{
				continue;
			}
			$add_pages[] = $row;
		}
		include_once(ABSOLUTE_PATH.Custom::path('modules/useradmin/views/useradmin.view.panel.php'));
	}
}