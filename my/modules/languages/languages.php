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
 * Languages
 */
class Languages extends Controller
{
	/**
	 * Шаблонная функция: выводит ссылки на альтернативные языковые версии сайта.
	 * 
	 * @param array $attributes атрибуты шаблонного тега
	 * template - шаблон тега (файл modules/languages/views/languages.view.show_block_**template**.php; по умолчанию шаблон modules/languages/views/languages.view.show_block.php)
	 * 
	 * @return void
	 */
	public function show_block($attributes)
	{
		$attributes = $this->get_attributes($attributes, 'template');

		$result["rows"] = $this->model->show_block();
		if (! $result["rows"])
			return;

		$result["attributes"] = $attributes;

		echo $this->diafan->_tpl->get('show_block', 'languages', $result["rows"], $attributes["template"]);
	}
}