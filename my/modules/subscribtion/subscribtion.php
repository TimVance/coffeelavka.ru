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

/**
 * Subscribtion
 */
class Subscribtion extends Controller
{
	/**
	 * Инициализация модуля
	 * 
	 * @return void
	 */
	public function init()
	{
		if(empty($_GET["action"]))
		{
			$_GET["action"] = '';
		}
		if(empty($_GET["mail"]))
		{
			$_GET["action"] = 'form';
		}
		switch($_GET["action"])
		{
			case "form":
				$this->model->form();
				break;

			case "del":
				$this->model->del();
				break;

			default:
				$this->model->edit();
		}		
	}

	/**
	 * Шаблонная функция: выводит форму подписки на рассылки.
	 * 
	 * @param array $attributes атрибуты шаблонного тега
	 * template - шаблон тега (файл modules/subscribtion/views/subscribtion.view.form_**template**.php; по умолчанию шаблон modules/subscribtion/views/subscribtion.view.form.php)
	 * 
	 * @return void
	 */
	public function show_form($attributes)
	{
		$attributes = $this->get_attributes($attributes, 'template');		

		$result = $this->model->form(true);
		$result["attributes"] = $attributes;

		echo $this->diafan->_tpl->get('form', 'subscribtion', $result, $attributes["template"]);
	}
}