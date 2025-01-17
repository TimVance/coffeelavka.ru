<?php
/**
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
 * Template
 * 
 * Представление в пользовательской части
 */
class Template extends Diafan
{
	/**
	 * @var array подключенные шаблоны модулей
	 */
	private $include_templates;

	/**
	 * Подключает шаблон
	 *
	 * @param string $name имя функции
	 * @param string $module название модуля
	 * @param mixed $result передаваемые в шаблон данные
	 * @param string $template атрибут template в шаблонном теге
	 * @return string
	 */
	public function get($name, $module, $result, $template = '')
	{
		$name = preg_replace('/[^a-z0-9_]+/', '', $name);
		$current_module = $this->diafan->current_module;
		$file = '';

		if(defined('IS_MOBILE') && IS_MOBILE)
		{
			if($template && Custom::exists('modules/'.$module.'/views/m/'.$module.'.view.'.$name.'_'.$template.'.php'))
			{
				$file = 'modules/'.$module.'/views/m/'.$module.'.view.'.$name.'_'.$template.'.php';
				$name .= '_'.$template;
			}
			if(! $file && Custom::exists('modules/'.$module.'/views/m/'.$module.'.view.'.$name.'.php'))
			{
				$file = 'modules/'.$module.'/views/m/'.$module.'.view.'.$name.'.php';
			}
		}
		if(! $file && $template && Custom::exists('modules/'.$module.'/views/'.$module.'.view.'.$name.'_'.$template.'.php'))
		{
			$file = 'modules/'.$module.'/views/'.$module.'.view.'.$name.'_'.$template.'.php';
			$name .= '_'.$template;
		}
		if(! $file && Custom::exists('modules/'.$module.'/views/'.$module.'.view.'.$name.'.php'))
		{
			$file = 'modules/'.$module.'/views/'.$module.'.view.'.$name.'.php';
		}
		$text = '';
		if($file)
		{
			ob_start();
			$this->diafan->current_module = $module;
			$this->js($name, $module);
			include(ABSOLUTE_PATH.Custom::path($file));
			$this->diafan->current_module = $current_module;
			$text = ob_get_contents();
			ob_end_clean();
		}
		return $text;
	}

	/**
	 * Подключает JS-файл
	 *
	 * @param string $name часть имени файла
	 * @param string $module название модуля
	 * @param boolean $is_mobile шаблон мобильной версии
	 * @return void
	 */
	public function js($name = '', $module = '', $is_mobile = false)
	{
		if(!  $module)
		{
			$module = $this->diafan->_site->module;
		}
		if(! empty($this->cache["include_".$name."_".$module.($is_mobile ? '_m' : '')."_js"]))
		{
			return;
		}
		$this->cache["include_".$name."_".$module.($is_mobile ? '_m' : '')."_js"] = true;

		$path = 'modules/'.$module.'/js/'.($is_mobile ? 'm/' : '').$module.($name ? '.'.preg_replace('/[^a-z0-9_]+/', '', $name) : '').'.js';
		if(Custom::exists($path))
		{
			$this->diafan->_site->js_view[] = $path;
		}
	}

	/**
	 * Заменяет шаблонные теги, ссылки в тексте
	 *
	 * @param string $text исходный текст
	 * @return string
	 */
	public function htmleditor($text)
	{
		$text = $this->diafan->_route->replace_id_to_link($text);
		return $this->diafan->_parser_theme->get_function_in_theme($text);
	}
}