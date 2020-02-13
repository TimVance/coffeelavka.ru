<?php
/**
 * Подключение модуля
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
 * Custom_inc
 */
class Custom_inc extends Diafan
{
	/**
	 * @var array папки и файлы, индексируеме для точек возврата
	 */
	private $folders = array('adm', 'css', 'img', 'themes', 'modules', 'includes', 'plugins', 'js');

	/**
	 * @var array папки и файлы, не индексируемые для точек возврата
	 */
	private $exclude = array('adm/htmleditor', 'includes/custom.php');

	/**
	 * Генерирует тему из кастомизированных файлов
	 *
	 * @return array
	 */
	public function generate()
	{
		// получает все файлы в текущей системе
		$current_files = array();
		if ($dir = opendir(ABSOLUTE_PATH))
		{
			while (($file = readdir($dir)) !== false)
			{
				if ($file == '.' || $file == '..' || ! in_array($file, $this->folders) || in_array($file, $this->exclude))
					continue;

				if(is_dir(ABSOLUTE_PATH.$file))
				{
					$this->read_dir(ABSOLUTE_PATH, $file, $current_files);
				}
				else
				{
					$current_files[$file] = file_get_contents(ABSOLUTE_PATH.$file);
				}
			}
			closedir($dir);
		}

		// получает все файлы из текущей точки возврата
		$return_id = DB::query_result("SELECT id FROM {update_return} WHERE current='1' LIMIT 1");
		$return_files = $this->diafan->_update->get_all_files($return_id);
		foreach($return_files as $k => $v)
		{
			$return_files[$k] = $v;
		}

		// находит кастомизированные файлы
		$custom_diff = array();
		foreach($current_files as $k => $file)
		{
			if(! isset($return_files[$k]) || str_replace("\r\n", "\n", $return_files[$k]) != str_replace("\r\n", "\n", $file))
			{
				$custom_diff[$k] = $file;
			}
			if($GLOBALS["custom"]["names"][0] && file_exists(ABSOLUTE_PATH.'custom/'.$GLOBALS["custom"]["names"][0].'/'.$k) && str_replace("\r\n", "\n", $file) == str_replace("\r\n", "\n", file_get_contents(ABSOLUTE_PATH.'custom/'.$GLOBALS["custom"]["names"][0].'/'.$k)))
			{
				File::delete_file('custom/'.$GLOBALS["custom"]["names"][0].'/'.$k);
			}
		}

		// находит файлы из текущей точки возврата, которые были изменены
		$return_diff = array();
		foreach($return_files as $k => $file)
		{
			if(! isset($current_files[$k]) || str_replace("\r\n", "\n", $current_files[$k]) != str_replace("\r\n", "\n", $file))
			{
				$return_diff[$k] = $file;
			}
		}
		if(! $custom_diff && ! $return_diff)
		{
			return 0;
		}

		// если нет текущей темы, создает новую тему, иначе добавляет кастомизированные файлы к текущей теме
		if(! Custom::name())
		{
			Custom::name('custom'.date("d_m_Y_H_i"));
			DB::query("INSERT INTO {custom} (name, created, text) VALUES ('%s', %d, '%s')", Custom::name(), time(), $this->diafan->_('Автоматически сгенерированная тема.'));
			Custom::inc('includes/config.php');
			$config = new Config();
			$config->save(array('CUSTOM' => Custom::name()), $this->diafan->_languages->all);
			File::create_dir('custom/'.Custom::name());
		}
		$result = array("custom" => array(), "return" => array());

		// добавляет кастомизированные файлы к текущей теме
		foreach($custom_diff as $k => $f)
		{
			if(! file_exists(ABSOLUTE_PATH.'custom/'.Custom::name().'/'.$k))
			{
				try
				{
					File::save_file($f, 'custom/'.Custom::name().'/'.$k);
				}
				catch (Exception $e){}
				$result["custom"][] = $k;
			}
		}

		// очищает основную систему от кастомизированных файлов
		foreach($custom_diff as $k => $f)
		{
			if(! isset($return_diff[$k]))
			{
				File::delete_file($k);
			}
		}

		// добавляет все файлы из текущей точки возврата
		foreach($return_diff as $k => $f)
		{
			if($f != 'deleted' && ! in_array($k, array('upgrade.php', 'downgrade.php')))
			{
				try
				{
					File::save_file($f, $k);
				}
				catch (Exception $e){}
				$result["return"][] = $k;
			}
		}
		return $result;
	}
	
	/**
	 * Читает папку в файлах точки
	 *
	 * @param string $path путь до файлов
	 * @param array $files получаемые файлы точки
	 * @return void
	 */
	private function read_dir($abspath, $path, &$files)
	{
		if ($dir = opendir($abspath.($path ? '/'.$path : '')))
		{
			while (($file = readdir($dir)) !== false)
			{
				if(($path ? $path.'/' : '').$file == USERFILES || in_array(($path ? $path.'/' : '').$file, $this->exclude))
				{
					continue;
				}
				if ($file != '.' && $file != '..')
				{
					if(is_dir($abspath.($path ? '/'.$path : '').'/'.$file))
					{
						$this->read_dir($abspath, ($path ? $path.'/' : '').$file, $files);
					}
					else
					{
						$files[($path ? $path.'/' : '').$file] = file_get_contents($abspath.($path ? '/'.$path : '').'/'.$file);
					}
				}
			}
			closedir($dir);
		}
	}
}