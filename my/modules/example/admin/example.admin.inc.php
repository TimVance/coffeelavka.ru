<?php
/**
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://cms.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2014 OOO «Диафан» (http://diafan.ru)
 */
if (!defined('DIAFAN'))
{
    include dirname(dirname(dirname(__FILE__))).'/includes/404.php';
}

/**
 * Example_admin_inc
 */
class Example_admin_inc extends Diafan
{
	/**
	 * Редактирование поля
	 * 
	 * @return void
	 */
	public static function edit()
	{
		echo '
		<tr>
			<td>EXAMPLE</td>
			<td>'.$this->diafan->module.'</td>
		</tr>';
	}

	/**
	 * Редактирование поля для конфигурации модуля
	 * 
	 * @return void
	 */
	public function edit_config()
	{
		echo '
		<tr>
			<td>EXAMPLE</td>
			<td>'.$this->diafan->module.'</td>
		</tr>';
	}

	/**
	 * Сохранение поля
	 */
	public function save(){}

	/**
	 * Сохранение настроек конфигурации модулей
	 * 
	 * @return void
	 */
	public function save_config(){}
}