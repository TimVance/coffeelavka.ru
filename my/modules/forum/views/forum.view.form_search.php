<?php
/**
 * Шаблон формы поиска по темам и сообщениям
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
<div class="forum_search">
	<form action="'.BASE_PATH_HREF.(! empty($result["action"]) ? $result["action"] : '').'" method="GET">
		<input type="text" name="searchword" value="'.(! empty($result["value"]) ? $result["value"] : '').'">
		<input type="submit" value="'.$this->diafan->_('Поиск', false).'">
	</form>
</div>';