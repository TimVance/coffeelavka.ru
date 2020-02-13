<?php
/**
 * Шаблон сообщения
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

echo '<form method="POST" class="ajax">
<a name="'.$result["id"].'"></a>
<input type="hidden" name="action" value="">
<input type="hidden" name="module" value="forum">
<input type="hidden" name="check_hash_user" value="'.$result["hash"].'">
<input type="hidden" name="id" value="'.$result["id"].'">';
echo
'<div class="forum_actions">
<span class="js_forum_actions">
<a href="#'.$result["id"].'" class="js_forum_action"><img src="'.BASE_PATH.'modules/forum/img/link.gif" title="'.$this->diafan->_('Ссылка', false).'" alt="'.$this->diafan->_('Ссылка', false).'"></a> ';
if ($result["access_edit_delete"])
{
	// удалить сообщение
	echo '<a href="javascript:void(0)" action="delete_message" title="'.$this->diafan->_('Вы действительно хотите удалить запись?', false).'" class="js_forum_action">'
	.'<img src="'.BASE_PATH.Custom::path('modules/forum/img/delete.gif').'" width="15" height="15"'
	.' title="'.$this->diafan->_('Удалить', false).'" alt="'.$this->diafan->_('Удалить', false).'">'
	.'</a>';

	// редактировать сообщение
	echo ' <a href="javascript:void(0)" action="edit_message" class="js_forum_action">'
	.'<img src="'.BASE_PATH.Custom::path('modules/forum/img/edit.gif').'" title="'.$this->diafan->_('Редактировать', false).'" alt="'.$this->diafan->_('Редактировать', false).'"></a>';
}
if ($result["access_block"])
{
	echo ' <a href="javascript:void(0)" action="block_message" class="js_forum_action">'
	.'<img src="'.BASE_PATH.Custom::path('modules/forum/img/'.($result["act"] ? 'block' : 'unblock').'.gif').'"
	title="'.(! $result["act"] ? $this->diafan->_('Разблокировать', false) : $this->diafan->_('Блокировать', false)).'"
	alt="'.(! $result["act"] ? $this->diafan->_('Разблокировать', false) : $this->diafan->_('Блокировать', false)).'"></a>';
}
echo '</span></div>';

if (! $result["act"])
{
	echo '<span class="forum_blocked">'.$this->diafan->_('Заблокировано')
	.($result["access_edit_delete"] ? ': '.$result["text"] : '').'</span>
	</form>';
}
else
{
	echo '<span class="forum_author">'.$this->get('author_message', 'forum', $result["user"]).'</span>, <span class="forum_date">'.$result['created'];
	if(! empty($result["date_update"]))
	{
		echo ', '.$this->diafan->_('редакция').($result["user_update"] ? ': '.$this->get('author', 'forum', $result["user_update"]).',' : '').' '.$result["date_update"];
	}
	echo '</span>
	<div class="forum_text">'.$result['text'].'</div>
	<div class="errors error" style="display:none"></div>
	'.$this->get('get_attachments', 'forum', $result["attachments"]).'
	</form>';
}