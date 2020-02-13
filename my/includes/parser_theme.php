<?php
/**
 * Парсер шаблонных функций
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

class Parser_theme extends Diafan
{
	/**
	 * @var string текущий модуль, для котого вызвана шаблонная функция
	 */
	public $current_module;

	/**
	 * @var boolean в текущий момент исполняется шаблонный тег
	 */
	public $is_tag;


	/**
	 * Подключает шаблон
	 * 
	 * @return void
	 */
	public function show_theme()
	{
		if(defined('IS_MOBILE') && IS_MOBILE)
		{
			$theme = $this->diafan->_site->theme;
			$this->diafan->_site->theme = 'm/'.$this->diafan->_site->theme;
			if (! Custom::exists('themes/'.$this->diafan->_site->theme))
			{
				if(in_array($theme, array('404.php', '403.php', '503.php')))
				{
					$this->diafan->_site->theme = $theme;
				}
				else
				{
					$this->diafan->_site->theme = 'm/site.php';
				}
			}
		}
		if (!$this->diafan->_site->theme || ! Custom::exists('themes/'.$this->diafan->_site->theme))
		{
			$this->diafan->_site->theme = 'site.php';
		}
		$site_theme = file_get_contents(ABSOLUTE_PATH.Custom::path('themes/'.$this->diafan->_site->theme));
		echo $this->get_function_in_theme($site_theme, true);
	}

	/**
	 * Парсит шаблон
	 *
	 * @param string $text содержание шаблона
	 * @param boolean $php исполнять PHP-код
	 * @return string
	 */
	public function get_function_in_theme($text, $php = false)
	{
		$result = '';
		if(! $php)
		{
			$text = preg_replace("/\<\?php([^?]+)\?\>/m", '', $text);
		}
		$text = preg_replace("/<\!--([^\/?noindex].*?)-->/m", '', $text);

		/*$text = preg_replace(
			array(
				'/<p>([^<]+)<insert/',
				'/<\/insert>([^<]*)<\/p>/',
				'/<\/insert>/'
			),
			array(
				'<insert',
				'</insert>',
				''
			),
			$text
		);*/
		if($php)
		{
			$text = $this->php_in_theme($text);
		}

		$regexp = '/(<insert(.*?)>)/ims';

		$tokens = preg_split($regexp, $text, -1, PREG_SPLIT_DELIM_CAPTURE);
		$cnt = count($tokens);
		$result .= $tokens[0];
		$i = 1;
		while ($i < $cnt)
		{
			$i++;
			$att_string = $tokens[$i++];
			$data 		= $tokens[$i++];
			$attributes = $this->parse_attributes($att_string);
			ob_start();
			$this->start_element($attributes);
			$result .= ob_get_contents();
			ob_end_clean();
			$result .= $data;
		}

		if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/aweb_seo/parse.php")) {
			require_once $_SERVER["DOCUMENT_ROOT"] . "/aweb_seo/parse.php";

			$link = explode("?", $_SERVER["REQUEST_URI"])[0];

			foreach($massObj as $metaArr) {
				if ($metaArr["﻿url"] == $link) {
					$T = $metaArr["title"];
					$D = $metaArr["description"];
					$K = $metaArr["keywords"];
				}
			}
			
			if (isset($T) && !empty($T)) {
				$result=preg_replace('/\<\s*title\s*\>.*\<\s*\/title\s*\>/isU','<title>'.$T.'</title>', $result);
				unset($T);
			}
			if (isset($D)&&!empty($D)) {
				if (preg_match('/\<\s*meta\s+name\s*=\s*"description.*\/\>/isU',$result)) {
					$result = preg_replace('/\<\s*meta\s+name\s*=\s*"description.*\>/isU','<meta name="description" content="'.$D.'" />',$result);
				} else {
					$result = preg_replace('/\<\/s*title>/isU','</title>'.PHP_EOL.'<meta name="description" content="'.$D.'" />',$result);
				}
				unset($D);
			}

		 	if (isset($K)&&!empty($K)) {
				if(preg_match('/\<\s*meta\s+name\s*=\s*"keywords.*\>/isU',$result)) {
					$result = preg_replace('/\<\s*meta\s+name\s*=\s*"keywords.*\>/isU','<meta name="keywords" content="'.$K.'" />',$result);
				} else {
					$result = preg_replace('/\<\/s*title>/isU','</title>'.PHP_EOL.'<meta name="keywords" content="'.$K.'" />',$result);
				}
				unset($K);
			}
		}
		return $result;
	}

	/**
	 * Исполняет PHP-код в шаблоне
	 *
	 * @param string $text содержание шаблона
	 * @return string
	 */
	private function php_in_theme($text)
	{
		$result = '';
		$regexp = '/(<\?php(.*?)\?>)/s';

		$tokens = preg_split($regexp, $text, -1, PREG_SPLIT_DELIM_CAPTURE);
		$cnt = count($tokens);
		$result .= $tokens[0];
		$i = 1;
		while ($i < $cnt)
		{
			$i++;
			ob_start();
			eval($tokens[$i++]);
			$result .= ob_get_contents();
			ob_end_clean();
			$result .= $tokens[$i++];
		}
		return $result;
	}
	

	/**
	 * Парсит атрибуты шаблонного тега
	 * 
	 * @return array
	 */
	private function parse_attributes($string)
	{
		$this->diafan->current_insert_tag = '<insert '.$string.'>';
		$entities = array(
			'&lt;' 		=> '<',
			'&gt;' 		=> '>',
			'[' 		=> '<',
			']' 		=> '>',
			'&amp;' 	=> '&',
			'&quot;' 	=> '"',
			'`' 		=> '"'
		);
		
		$attributes = array();
		$match = array();
		preg_match_all('/([a-zA-Z_0-9]+)="((?:\\\.|[^"\\\])*)"/U', $string, $match);
		for ($i = 0; $i < count($match[1]); $i++)
		{
			$attributes[strtolower($match[1][$i])] = strtr((string)$match[2][$i], $entities);
		}
		return $attributes;
	}

	/**
	 * Выполняет действие, заданное в шаблонном тэге: выводит информацию или подключает шаблонную функцию
	 *
	 * @param array атрибуты шаблонного тега
	 * @return void
	 */
	private function start_element($attributes)
	{
		$this->is_tag = true;
		if (empty($attributes['name']))
		{
			if(!  empty($attributes['value']))
			{
				echo $this->diafan->_($attributes['value']);
			}
		}
		else
		{
			$attributes['name'] = preg_replace('/[^a-zA-Z0-9_]/', '', $attributes['name']);

			$current_module = $this->diafan->current_module;
			if (! empty($attributes['module']))
			{
				$attributes['module'] = preg_replace('/[^a-zA-Z0-9_]/', '', $attributes['module']);
				$mod = ucfirst($attributes['module']);
				
				$this->diafan->current_module = $attributes['module'];

				if(in_array($attributes['module'], $this->diafan->installed_modules))
				{
					if (Custom::exists('modules/'.$attributes['module'].'/'.$attributes['module'].'.php'))
					{
						Custom::inc('modules/'.$attributes['module'].'/'.$attributes['module'].'.php');
						$module = new $mod($this->diafan, $attributes['module']);

						if (is_callable(array($module, $attributes['name'])))
						{
							call_user_func_array (array(&$module, $attributes['name']), array($attributes));
						}
					}
				}
			}
			else
			{
				$this->functions($attributes['name'], $attributes);
			}
			$this->diafan->current_module = $current_module;
		}
		$this->is_tag = false;
	}

	/**
	 * Подключает файл, описывающий общий шаблонны тег
	 *
	 * @param string $name название шаблонного тега
	 * @param array $attributes атрибуты шаблонного тега
	 * @return void
	 */
	public function functions($name, $attributes = array())
	{
		$name = preg_replace('/[^a-zA-Z0-9_]/', '', $name);
		if(Custom::path('themes/functions/'.$name.'.php'))
		{
			include(ABSOLUTE_PATH.Custom::path('themes/functions/'.$name.'.php'));
		}
		else
		{
			Dev::other_error_catcher(239, 'Файл themes/functions/'.$name.'.php не существует.');
		}
	}

	/**
	 * Задает неопределенным атрибутам шаблонного тега значение по умолчанию
	 * 
	 * @param array $attributes массив определенных атрибутов
	 * @return array
	 */
	public function get_attributes($attributes)
	{
		$a = func_get_args();
		for ($i = 1; $i < count($a); $i++)
		{
			if (is_array($a[$i]))
			{
				$name = $a[$i][0];
				$value = $a[$i][1];
			}
			else
			{
				$name = $a[$i];
				$value = '';
			}
			if (empty($attributes[$name]))
			{
				$attributes[$name] = $value;
			}
		}
		return $attributes;
	}
}