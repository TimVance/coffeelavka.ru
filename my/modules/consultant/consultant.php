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

class Consultant extends Controller
{
	/**
	 * Шаблонная функция: подключает on-line консультант.
	 * 
	 * @param array $attributes атрибуты шаблонного тега
	 * template - шаблон тега (файл modules/consultant/views/consultant.view.show_block_**template**.php; по умолчанию шаблон modules/consultant/views/consultant.view.show_block.php)
	 * 
	 * @return void
	 */
	public function show_block($attributes)
	{
		$attributes = $this->get_attributes($attributes, 'template', 'system');
		$attributes["system"] = ! in_array($attributes["system"], array('redhelper', 'livetex', 'jivosite')) ? 'redhelper' : $attributes["system"];

		$result["code"] = $this->model->show_block($attributes["system"]);
		$result["attributes"] = $attributes;

		echo $this->diafan->_tpl->get('show_block', 'consultant', $result, $attributes["template"]);
	}
}