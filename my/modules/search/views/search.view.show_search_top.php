<?php
/**
 * Шаблон формы поиска по сайту, template=top
 *
 * Шаблонный тег <insert name="show_search" module="search" template="top"
 * [button="надпись на кнопке"]>:
 * форма поиска по сайту
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

echo '
	<form action="'.$result["action"].'" class="navbar-form navbar-right js_search_form search_form'.($result["ajax"] ? ' ajax" method="post"' : '" method="get"').' id="search">
	<div class="input-group">
	<input type="hidden" name="module" value="search">
	<input id="textbox" class="form-control" type="text" name="searchword" placeholder="'.$this->diafan->_('Что ищем?', false).'">
	<span class="input-group-btn">
  		<button class="btn btn-default btn-default_mod " type="submit">
            <i class="glyphicon glyphicon-search"></i>
        </button>
  	</span>
	</div>
	</form>';
if($result["ajax"])
{
	echo '<div class="js_search_result search_result"></div>';
}
