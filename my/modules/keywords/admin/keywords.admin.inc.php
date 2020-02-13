<?php
/**
 * Подключение модуля к административной части других модулей
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

class Keywords_admin_inc extends Diafan
{
	/**
	 * Редактирование поля "Подключить перелинковку" для настроек модуля
	 * 
	 * @return void
	 */
	public function edit_config()
	{
		echo '
		<div class="unit" id="'.$this->diafan->key.'">
			<input type="checkbox" id="input_'.$this->diafan->key.'" name="'.$this->diafan->key.'" value="1"'.($this->diafan->value ? " checked" : '' ).'>
			<label for="input_'.$this->diafan->key.'"><b>'.$this->diafan->variable_name().$this->diafan->help().'</b></label>
		</div>';
	}

	/**
	 * Сохранение настроек модулей
	 * 
	 * @return void
	 */
	public function save_config()
	{
		$this->diafan->set_query("keywords='%d'");
		$this->diafan->set_value(! empty($_POST["keywords"]) ? $_POST["keywords"] : '');
	}
}