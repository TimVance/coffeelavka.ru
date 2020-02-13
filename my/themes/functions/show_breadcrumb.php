<?php
/**
 * Шаблонный тег: выводит навигацию по сайту «Хлебные крошки».
 *
 * @param array $attributes атрибуты шаблонного тега
 * separator - разделитель ссылок в навигации
 * current - выводить текущий пункт: **true** – выводить ссылку на текущую страницу, по умолчанию ссылка на текущую страницу не выводится
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

if ($this->diafan->_site->id == 1 && ! $this->diafan->_site->breadcrumb)
{
	return;
}
$attributes = $this->get_attributes($attributes, 'separator', 'current');

if ($this->diafan->_site->id == 1 && ! $this->diafan->_route->cat && ! $this->diafan->_route->show && ! $this->diafan->_route->brand)
	return;

$separator = $attributes["separator"] ? str_replace(array('src="/', '[', ']'), array('src="'.BASE_PATH, '<', '>'), $attributes["separator"]) : '';
$current = ! $attributes["current"] || $attributes["current"] == 'false' ? false : true;

if ($this->diafan->_site->parent_id)
{
	$cache_meta = array(
			"name"     => "page",
			"id"       => $this->diafan->_site->id,
			"lang_id"  => _LANG
		);
	$page = $this->diafan->_cache->get($cache_meta, 'site');
	if (! isset($page["breadcrumb"]))
	{
		$page["breadcrumb"] = array();
		if($this->diafan->_site->parents)
		{
			$rparents = DB::query_fetch_key("SELECT id, [name], parent_id FROM {site} WHERE id IN (%h)", implode(',', $this->diafan->_site->parents), "parent_id");
			$i = 0;
			while(! empty($rparents[$i]))
			{
				$row = $rparents[$i];
				unset($rparents[$i]);
				$i = $row["id"];
				$row["link"] = $this->diafan->_route->link($row["id"]);
				$page["breadcrumb"][] = $row;
			}
		}
		//сохранение кеша
		$this->diafan->_cache->save($page, $cache_meta, 'site');
	}
}
echo '<ol class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';

if ($this->diafan->_site->id != 1)
{
	echo  '<li typeof="v:Breadcrumb"><a href="'.BASE_PATH_HREF.'" rel="v:url" property="v:title">'.$this->diafan->_('Главная').'</a> '.$separator.' </li>';
}
if ($this->diafan->_site->parent_id)
{
	foreach ($page["breadcrumb"] as $row)
	{
		echo '<li typeof="v:Breadcrumb"><a href="'.BASE_PATH_HREF.$row["link"].'" rel="v:url" property="v:title">'.$this->diafan->_useradmin->get($row["name"], 'name', $row["id"], 'site', _LANG).'</a> '.$separator.' </li>';
	}
}
if ($this->diafan->_site->breadcrumb)
{
	foreach ($this->diafan->_site->breadcrumb as $breadcrumb)
	{
		if ($this->diafan->_site->breadcrumb[0] == $breadcrumb)
		{
			$breadcrumb["name"] = $this->diafan->_useradmin->get($breadcrumb["name"], 'name', $this->diafan->_site->id, 'site', _LANG);
		}
		echo '<li typeof="v:Breadcrumb"><a href="'.BASE_PATH_HREF.$breadcrumb["link"].'" rel="v:url" property="v:title">'.$breadcrumb["name"].'</a> '.$separator.' </li>';
	}
}
if($current)
{
	if ($this->diafan->_site->titlemodule)
	{
		$name = $this->diafan->_site->titlemodule;
	}
	else
	{
		$name = $this->diafan->_site->name;
	}
	echo ' <li class="active" typeof="v:Breadcrumb">'.$name.'</li>';
}
echo '</ol>';