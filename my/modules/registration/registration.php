<?php
/**
 * Контроллер модуля «Регистрация»
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
 * Registration
 */
class Registration extends Controller
{
	/**
	 * Инициализация модуля
	 * 
	 * @return void
	 */
	public function init()
	{
		if(! empty($_GET["action"]))
		{
			switch($_GET["action"])
			{
				case "act":
					$this->result = $this->model->act();
					break;

				case "success":
					$this->result = $this->model->success();
					break;

				default:
					Custom::inc('includes/404.php');
			}
		}
		else
		{
			if($this->diafan->_users->id)
			{
				$this->diafan->redirect();
			}
			$this->result = $this->model->form();
		}
	}

	/**
	 * Обрабатывает полученные данные из формы
	 * 
	 * @return void
	 */
	public function action()
	{
		if(! empty($_POST["action"]) && $_POST["action"] == 'auth')
		{
			return $this->action->auth();
		}

		if ($this->diafan->_site->module != 'registration' || $this->diafan->_users->id)
		{
			return;
		}

		if(! empty($_POST["action"]))
		{
			switch($_POST["action"])
			{
				case 'add':
					return $this->action->add();
	
				case 'fast_validate':
					return $this->action->fast_validate();
	
				case 'upload_image':
					return $this->action->upload_image();
	
				case 'delete_image':
					return $this->action->delete_image();
			}
		}
	}

	/**
	 * Шаблонная функция: выводит форму авторизации или приветствие и ссылки на редактирование данных и выход, если пользователь авторизован.
	 * 
	 * @param array $attributes атрибуты шаблонного тега
	 * template - шаблон тега (файл modules/registration/views/registration.view.show_login_**template**.php; по умолчанию шаблон modules/registration/views/registration.view.show_login.php)
	 * 
	 * @return void
	 */
	public function show_login($attributes)
	{
		$attributes = $this->get_attributes($attributes, 'template');
		$result = $this->model->show_login();
		$result["attributes"] = $attributes;

		echo $this->diafan->_tpl->get('show_login', 'registration', $result, $attributes["template"]);
	}  	
}