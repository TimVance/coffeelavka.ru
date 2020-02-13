<?php
/**
 * Шаблон страницы темы
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

if (! empty($result["close"]))
{
	echo '<div class="forum_active">'.$this->diafan->_('Тема закрыта').'</div>';
}
echo '<input type="hidden" name="check_hash_user" value="'.$result["hash"].'">';
echo '<div class="forum_messages"'.(empty($result["rows"]) ? ' style="display:none"' : '').'>';
if (! empty($result["rows"]))
{
	echo $this->get('list_messages', 'forum', $result["rows"]);
}
echo '</div>';

echo $result["paginator"];

if($result["form"])
{	
	echo '<div class="block_header forum_form_header">' . $this->diafan->_("Ответить в теме") . '</div>';
	echo $this->get('form_message', 'forum', $result["form"]);
}
