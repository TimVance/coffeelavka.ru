<?php
/**
 * Общие функции ядра
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
 * Core
 *
 * Общие функции ядра
 */
abstract class Core
{
	/**
	 * @var array настройки модуля
	 */
	private $configmodules = array();

	/**
	 * @var array кэш родителей
	 */
	private $get_parents_cache = array();

	/**
	 * Редирект
	 *
	 * @param string $url URL для редиректа
	 * @param integer $http_response_code статус-код
	 * @return void
	 */
	public function redirect($url = '', $http_response_code = 302)
	{
		if (substr($url, 0, 4) != 'http')
		{
			$url = BASE_PATH_HREF.$url;
		}
		$url = str_replace(array("\n", "\r", '&amp;'), array('', '', '&'), $url);
		header('Location: '.$url, true, $http_response_code);
		exit;
	}

	/**
	 * Редиректс помошью JavaScript
	 *
	 * @param string $url URL для редиректа
	 * @return void
	 */
	public function redirect_js($url = '')
	{
		if (substr($url, 0, 4) != 'http')
		{
			$url = BASE_PATH_HREF.$url;
		}

		$url = str_replace(array("\n", "\r"), '', $url);
		echo '<script language="javascript" type="text/javascript">window.location.href=\''.$url.'\';</script>';
		exit;
	}

	/**
	 * Приводит значение переменной к типу, соответстветствующему маске
	 *
	 * @param mixed $array исходное значение или массив с исходным значением
	 * @param string $mask тип преобразования: *url* – преобразует строку для использования ее в ссылке, *sql* – переменную можно вставлять непосредственно в SQL-запрос, *int* – оставляет только числа, *float* – дискретное число, *string* – удаляются HTML-теги, специальные символы преобразуются
	 * @param string $name имя переменной в массиве
	 * @param mixed $default значение по-умолчанию
	 * @return mixed
	 */
	public function filter($array, $mask = 0, $name = '', $default = '')
	{
		if(! $default)
		{
			switch($mask)
			{
				case 'url':
				case 'string':
				case 'sql':
					$default = '';
					break;
	
				case 'int':
				case 'integer':
				case 'float':
					$default = 0;
					break;
	
				default:
					$default = null;
					break;
			}
		}
		if(is_array($array) && $name)
		{
			if (array_key_exists($name, $array))
			{
				$value = $array[$name];
			}
			else
			{
				return $default;
			}
		}
		else
		{
			$value = $array;
		}
		if (is_array($value))
		{
			return $value;
		}
		switch($mask)
		{
			case 'url':
				return urlencode($value);

			case 'string':
				return trim(htmlspecialchars(strip_tags($value)));

			case 'sql':
				return addslashes(str_replace("%", "%%", $value));

			case 'int':
			case 'integer':
				return (int) preg_replace("/\D/", "", $value);

			case 'float':
				return (float) preg_replace("/[^0-9\.+]/", "", str_replace(',', '.', $value));

			default:
				return trim($value);
		}
	}

	/**
	 * Возвращает значение переменной $name в конфигурации модуля $module_name для языковой версии
	 * $lang_id и страницы $site_id. Если задано значение $value, функция записывает новое значение.
	 *
	 * @param string $name имя переменной в конфигурации
	 * @param string $module_name название модуля
	 * @param integer $site_id раздел сайта
	 * @param integer $lang_id номер языковой версии
	 * @param boolean $value новое значение
	 * @return mixed
	 */
	public function configmodules($name, $module_name = '', $site_id = false, $lang_id = false, $value = false)
	{
		if($lang_id  === false)
		{
			if(defined('_LANG'))
			{
				$lang_id = _LANG;
			}
			else
			{
				$lang_id = 1;
			}
		}
		if (! $site_id)
		{
			if($site_id === false)
			{
				if (IS_ADMIN)
				{
					$site_id = $this->_route->site;
				}
				else
				{
					$site_id = $this->_site->id;
				}
			}
			if (! $site_id)
			{
				$site_id = 0;
			}
		}
		if (! $module_name)
		{
			if (IS_ADMIN)
			{
				$module_name = $this->_admin->module;
			}
			else
			{
				$module_name = $this->_site->module;
			}
		}
		if (empty($this->configmodules))
		{
			$rs = DB::query_fetch_all("SELECT * FROM {config}");
			foreach($rs as $r)
			{
				$this->configmodules[$r["module_name"]][$r["site_id"].$r["name"].$r["lang_id"]] = $r["value"];
			}
		}
		if(IS_DEMO && (! defined('IS_INSTALL') || ! IS_INSTALL) && ! $this->configmodules)
		{
			return;
		}
		if($value !== false)
		{
			if(isset($this->configmodules[$module_name][$site_id.$name.$lang_id]))
			{
				if($this->configmodules[$module_name][$site_id.$name.$lang_id] != $value)
				{
					if(! $value && (! $site_id || empty($this->configmodules[$module_name]['0'.$name.$lang_id])))
					{
						DB::query("DELETE FROM {config} WHERE module_name='%h' AND site_id=%d AND name='%h' AND lang_id=%d", $module_name, $site_id, $name, $lang_id);
					}
					else
					{
						DB::query("UPDATE {config} SET value='%s' WHERE module_name='%h' AND site_id=%d AND name='%h' AND lang_id=%d", $value, $module_name, $site_id, $name, $lang_id);
					}
				}
			}
			else
			{
				DB::query("INSERT INTO {config} (value, module_name, site_id, name, lang_id) VALUES ('%s', '%h', %d, '%h', %d)", $value, $module_name, $site_id, $name, $lang_id);
			}
			$this->configmodules[$module_name][$site_id.$name.$lang_id] = $value;
			return;
		}
		if(! $this->configmodules)
		{
			return;
		}
		$value = false;
		if (isset($this->configmodules[$module_name][$site_id.$name.$lang_id]))
		{
			$value = $this->configmodules[$module_name][$site_id.$name.$lang_id];
		}
		elseif ($lang_id && isset($this->configmodules[$module_name]['0'.$name.$lang_id]))
		{
			$value = $this->configmodules[$module_name]['0'.$name.$lang_id];
		}
		elseif (isset($this->configmodules[$module_name][$site_id.$name.'0']))
		{
			$value = $this->configmodules[$module_name][$site_id.$name.'0'];
		}
		elseif (isset($this->configmodules[$module_name]['0'.$name.'0']))
		{
			$value = $this->configmodules[$module_name]['0'.$name.'0'];
		}
		return $value;
	}

	/**
	 * Сокращает текст
	 *
	 * @param string $text исходный текст
	 * @param integer $length количество символов для сокращения
	 * @return string
	 */
	public function short_text($text, $length = 80)
	{
		$text = strip_tags($text);
		if(strlen($text) > 100000)
		{
			$text = substr($text, 0, 100000);
		}
		if (utf::strlen($text) > $length + 20)
		{
			$cut_point = utf::strlen($text) - utf::strlen(utf::stristr(utf::substr($text, $length), " "));
			$text = utf::substr($text, 0, $cut_point).'...';
		}
		return $text;
	}

	/**
	 * Подготавливает текст для отображения в XML-файле
	 *
	 * @param string $text исходный текст
	 * @return string
	 */
	public function prepare_xml($text)
	{
		$repl = array('&nbsp;', '"','&','>','<',"'");
		$replm = array(' ', '&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
		
		$text = str_replace($repl, $replm, strip_tags($text));
		return $text;
	}

	/**
	 * Конвертирует количество бит в байты, килобайты, мегабайты
	 *
	 * @param integer $size размер в байтах
	 * @return string
	 */
	public function convert($size)
	{
		if (!$size)
		{
			return '';
		}
		$measure = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb', 'Eb', 'Zb', 'Yb');
		return round($size / pow(1024, ($exp = floor(log($size, 1024)))), 2).' '.$measure[$exp];
	}

	/**
	 * Кодирует пароль
	 *
	 * @param string $text исходный пароль
	 * @return string
	 */
	public function encrypt($text)
	{
		return md5($text);
	}

	/**
	 * Выдает массив номеров детей
	 *
	 * @param integer $id номер исходного элемента
	 * @param string $table таблица
	 * @param boolean $trash не учитывать элементы, удаленные в корзину
	 * @return array
	 */
	public function get_children($id, $table, $trash = true)
	{
		$chidren = DB::query_fetch_value("SELECT element_id FROM {".$table."_parents} WHERE parent_id=%d".(! in_array($table, array("trash", "admin")) ? " AND trash='0'": ''), $id, "element_id");
		return $chidren;
	}

	/**
	 * Выдает массив номеров родителей
	 *
	 * @param integer|array $id номер исходного элемента
	 * @param string $table таблица
	 * @return array
	 */
	public function get_parents($id, $table)
	{
		if(is_array($id))
		{
			$id = preg_replace('/[^0-9\,]+/', '', implode(',', $id));
			$where = ' IN (%s)';
		}
		else
		{
			$where = '=%d';
		}
		$parents = DB::query_fetch_value("SELECT parent_id FROM {".$table."_parents} WHERE element_id".$where
			.(! in_array($table, array("trash", "admin")) ? " AND trash='0'": ''), $id, "parent_id");
		return $parents;
	}

	/**
	 * Переводит кириллицу в транслит для строки text
	 *
	 * @param string $text исходный текст
	 * @return string
	 */
	public function translit($text)
	{
		$ru = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ы', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ы', 'Э', 'Ю', 'Я', ' ');

		$tr = array('a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'sch', 'y', 'e', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'ZH', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'KH', 'TS', 'CH', 'SH', 'SCH', 'Y', 'E', 'YU', 'YA', '-');
		return preg_replace('/[^A-Za-z0-9-_\.\/]+/', '', str_replace($ru, $tr, $text));
	}

	/**
	 * Переводит дату из в формата гггг-мм-дд в формат дд.мм.гггг
	 *
	 * @param string $date дата в формате гггг-мм-дд
	 * @return string
	 */
	public function formate_from_date($date)
	{
		if(! preg_match('/^(\d{4})\-(\d{2})\-(\d{2})$/', trim($date), $matches))
		{
			return '00.00.0000';
		}
		list($dummy, $year, $month, $day) = $matches;
		if($day > 31)
		{
			$day = 31;
		}
		if($month > 12)
		{
			$month = 12;
		}
		$date = $day.'.'.$month.'.'.$year;
		return $date;
	}

	/**
	 * Переводит дату из в формата гггг-мм-дд чч:мм в формат дд.мм.гггг чч:мм
	 *
	 * @param string $date дата в формате гггг-мм-дд чч:мм
	 * @return string
	 */
	public function formate_from_datetime($date)
	{
		if(! preg_match('/^(\d{4})\-(\d{2})\-(\d{2})\s+(\d{2})\:(\d{2})$/', trim($date), $matches))
		{
			return '00.00.0000 00:00';
		}
		list($dummy, $year, $month, $day, $hour, $minutes) = $matches;
		if($day > 31)
		{
			$day = 31;
		}
		if($month > 12)
		{
			$month = 12;
		}
		if($hour > 23)
		{
			$hour = 23;
		}
		if($minutes > 59)
		{
			$minutes = 59;
		}
		$date = $day.'.'.$month.'.'.$year.' '.$hour.':'.$minutes;
		return $date;
	}

	/**
	 * Переводит дату из в формата дд.мм.гггг в формат гггг-мм-дд
	 *
	 * @param string $date дата в формате дд.мм.гггг
	 * @return string
	 */
	public function formate_in_date($date)
	{
		if(! preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', trim($date), $matches))
		{
			return '0000-00-00';
		}
		list($dummy, $day, $month, $year) = $matches;
		if($day > 31)
		{
			$day = 31;
		}
		if($month > 12)
		{
			$month = 12;
		}
		$date = $year.'-'.$month.'-'.$day;
		return $date;
	}

	/**
	 * Переводит дату из в формата дд.мм.гггг чч:мм в формат гггг-мм-дд чч:мм
	 *
	 * @param string $date дата в формате дд.мм.гггг чч:мм
	 * @return string
	 */
	public function formate_in_datetime($date)
	{
		if(! preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})\s+(\d{1,2})\:(\d{1,2})$/', trim($date), $matches))
		{
			return '0000-00-00 00:00';
		}
		list($dummy, $day, $month, $year, $hour, $minutes) = $matches;
		if($day > 31)
		{
			$day = 31;
		}
		if($month > 12)
		{
			$month = 12;
		}
		if($hour > 23)
		{
			$hour = 23;
		}
		if($minutes > 59)
		{
			$minutes = 59;
		}
		$date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minutes;
		return $date;
	}

	/**
	 * Возвращает дату, переданную в формате dd.mm.yyyy hh:ii в виде даты в формате UNIX
	 *
	 * @param string $date дата в формате dd.mm.yyyy hh:ii
	 * @return integer
	 */
	public function unixdate($date)
	{
		if(! $date)
		{
			return 0;
		}
		$return = 0;
		if(preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})\s+(\d{1,2})\:(\d{1,2})$/', trim($date), $matches))
		{
			list($dummy, $day, $month, $year, $hour, $minutes) = $matches;
			if($day > 31)
			{
				$day = 31;
			}
			if($month > 12)
			{
				$month = 12;
			}
			if($hour > 23)
			{
				$hour = 23;
			}
			if($minutes > 59)
			{
				$minutes = 59;
			}
			$return = mktime($hour, $minutes, 0, $month, $day, $year);
		}
		elseif(preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', trim($date), $matches))
		{
			list($dummy, $day, $month, $year) = $matches;
			if($day > 31)
			{
				$day = 31;
			}
			if($month > 12)
			{
				$month = 12;
			}
			$return = mktime(0, 0, 0, $month, $day, $year);
		}
		return $return;
	}

	/*
	 * Борьба с магическими кавычками
	 *
	 * @return void
	 */
	protected function magic_quote_off()
	{
		if (get_magic_quotes_gpc())
		{
			$_GET = $this->stripslashes_array($_GET);
			$_POST = $this->stripslashes_array($_POST);
		}
	}

	/*
	 * Вырезает магические кавычки из массива
	 *
	 * @param array $array исходный массив
	 * @return array
	 */
	protected function stripslashes_array($array)
	{
		if (is_array($array))
		{
			foreach ($array as $key => $value)
			{
				$array[$key] = $this->stripslashes_array($value);
			}
			return $array;
		}
		else
		{
			return stripslashes($array);
		}
	}
}
