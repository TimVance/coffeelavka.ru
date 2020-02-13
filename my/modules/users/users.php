<?php
/**
 * Котроллер модуля «Пользователи на сайте»
 * 
 * @package    DIAFAN.CMS
 *
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
 * Users
 */
class Users extends Controller
{
	/**
	 * Шаблонная функция: выводит статистику пользователей на сайте
	 * 
	 * @param array $attributes атрибуты шаблонного тега
	 * template - шаблон тега (файл modules/users/views/users.view.show_block_**template**.php; по умолчанию шаблон modules/users/views/users.view.show_block.php)
	 * 
	 * @return void
	 */
	public function show_block($attributes)
	{
		$attributes = $this->get_attributes($attributes, 'template');

		$result = $this->model->show_block();
		$result["attributes"] = $attributes;

		echo $this->diafan->_tpl->get('show_block', 'users', $result, $attributes["template"]);
	}
}
