<?php
/**
 * Шаблон блока тем форума
 * 
 * Шаблонный тег <insert name="show_block" module="forum" [count="количество"]
 * [cat_id="категория"] [template="шаблон"]>:
 * блок последних тем
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

if(! $result["rows"])
	return;

echo '
<div class="block_header">'.$this->diafan->_('Последние темы на форуме').'</div>
<ul class="forum_block">';
foreach ($result["rows"] as $row)
{
	echo '<li><a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a></li>';
}
echo '</ul><br><br>';
