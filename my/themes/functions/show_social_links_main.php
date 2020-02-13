<?php
/**
 * [Шаблонный тег]: выводит ссылки на социальные сети.
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

if ($this->diafan->_site->titlemodule_meta)
{
	$title = $this->diafan->_site->titlemodule_meta;
}
if($this->diafan->_route->page > 1)
{
	$page = $this->diafan->_(' — Страница %d', false, $this->diafan->_route->page);
}
else
{
	$page = '';
}
if($this->diafan->configmodules('title_tpl', 'site'))
{
	if($this->diafan->_site->parent_id && ! $this->diafan->_site->parent_name
	   && strpos($this->diafan->configmodules("title_tpl", 'site'), '%parent') !== false)
	{
		$this->diafan->_site->parent_name = DB::query_result("SELECT [name] FROM {site} WHERE id=%d", $this->diafan->_site->parent_id);
	}
	$this->diafan->_site->title_meta = str_replace(
		array('%title', '%name', '%parent'),
		array($this->diafan->_site->title_meta, $this->diafan->_site->name, $this->diafan->_site->parent_name),
		$this->diafan->configmodules("title_tpl", 'site')
	);
	$title = $this->diafan->_site->title_meta.$page;	
}
if ($this->diafan->_site->title_meta)
{
	$title = ($this->diafan->_site->titlemodule ? $this->diafan->_site->titlemodule.' — ' : '').$this->diafan->_site->title_meta.$page;	
}
$title = ($this->diafan->_site->titlemodule ? $this->diafan->_site->titlemodule.' — ' : '').$this->diafan->_site->name.$page.(TITLE ? ' — '.TITLE : '');

$title = rawurlencode($title);

echo '
<div class="socials">
      <h3>'.$this->diafan->_('Социальные сети').'</h3>
       <a href="http://share.yandex.ru/go.xml?service=vkontakte&amp;url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&amp;title='.$title.'"><img src="'.BASE_PATH.Custom::path('img/icon_soc_vk.png').'"/></a>
       <a href="http://share.yandex.ru/go.xml?service=odnoklassniki&amp;url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&tamp;itle='.$title.'"><img src="'.BASE_PATH.Custom::path('img/icon_soc_odnoklassniki.png').'"/></a>
       <a href="http://share.yandex.ru/go.xml?service=twitter&amp;url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&amp;title='.$title.'"><img src="'.BASE_PATH.Custom::path('img/icon_soc_twitter.png').'"/></a>
       <a href="http://share.yandex.ru/go.xml?service=facebook&amp;url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&amp;title='.$title.'"><img src="'.BASE_PATH.Custom::path('img/icon_soc_facebook.png').'"/></a>
    </div>';
