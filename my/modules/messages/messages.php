<?php
/**
 * Контроллер
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

class Messages extends Controller
{
	/**
	 * @var array переменные, передаваемые в URL страницы
	 */
	public $rewrite_variable_names = array('page', 'show');

	/**
	 * Инициализация модуля
	 * 
	 * @return void
	 */
    public function init()
    {
		if(! $this->diafan->_users->id)
		{
			Custom::inc('includes/404.php');
		}
		if ($this->diafan->_route->show)
		{
			$this->model->id();
		}
		else
		{
			$this->model->list_();
		}
    }
}