<?php
/**
 * Модель
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
 * Languages_model
 */
class Languages_model extends Model
{
	/**
	 * Генерирует данные для шаблонной функции: блок ссылок на языковые версии сайта
	 *
	 * @return array
	 */
	public function show_block()
	{
		if (count($this->diafan->_languages->all) < 2)
		{
			return false;
		}

		$result = array();
		foreach ($this->diafan->_languages->all as $row)
		{
			if($row["id"] != _LANG)
			{
				$query_string = ($_GET["rewrite"] && ! empty($row["page_act"]) ? $_GET["rewrite"].(ROUTE_END == '/' ? '/' : ''): '')
				.$this->diafan->_site->query_string;
				$row["current"] = false;
				$row["link"] = BASE_PATH.(! $row["base_site"] ? $row["shortname"].'/' : '').$query_string;
				if(! $query_string && IS_DEMO)
				{
					$row["link"] .= '?'.rand(0, 999);
				}
				
			}
			else
			{
				$row["current"] = true;
				$row["link"] = '';
			}
			$row["name"] = $this->diafan->_useradmin->get($row["name"], 'name', $row["id"], 'languages');
			$result[] = $row;
		}

		return $result;
	}
}