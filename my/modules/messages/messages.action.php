<?php
/**
 * Обработка POST-запроса
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

class Messages_action extends Action
{
	/**
	 * Обрабатывает запрос на добавление сообщения
	 * 
	 * @return void
	 */
    public function init()
    {
		$this->check_user();

		if ($this->result())
			return;

		$this->check_fields();

		if ($this->result())
			return;

		DB::query("INSERT INTO {messages} (created, author, to_user, text) VALUES (%d, %d, %d, '%s')", time(), $this->diafan->_users->id, $_POST['to'], $_POST["message"]);
	
		if (DB::query_result("SELECT id FROM {messages_user} WHERE user_id=%d AND contact_user_id=%d LIMIT 1", $this->diafan->_users->id, $_POST['to']))
		{
			// обновляем информацию о контакте: дата обновления, количество сообщений и пометка "непрочитанный" у контакта получателя
			DB::query("UPDATE {messages_user} SET date_update=%d, count_message=count_message+1 WHERE user_id=%d AND contact_user_id=%d", time(), $this->diafan->_users->id, $_POST['to']);
			DB::query("UPDATE {messages_user} SET date_update=%d, count_message=count_message+1, readed='0' WHERE contact_user_id=%d AND user_id=%d", time(), $this->diafan->_users->id, $_POST['to']);
		}
		else
		{
			// добавляем контакт автору и получателю
			DB::query("INSERT INTO {messages_user} (date_update, count_message, user_id, contact_user_id, readed) VALUES (%d, '1', %d, %d, '1')", time(), $this->diafan->_users->id, $_POST['to']);
			DB::query("INSERT INTO {messages_user} (date_update, count_message, user_id, contact_user_id) VALUES (%d, '1', %d, %d)", time(), $_POST['to'], $this->diafan->_users->id);
		}
	
		if(empty($_POST['redirect']))
		{
			$this->result['redirect'] = BASE_PATH_HREF.$this->diafan->_route->module('messages', false).'show'.intval($_POST['to']).'/';
		}
		else
		{
			$this->result['redirect'] = BASE_PATH_HREF.$this->diafan->_route->current_link("page");
		}

		$this->result['result'] = 'success';
    }

    /**
     * Валидация введенных данных
     * 
     * @return void
     */
    private function check_fields()
    {
		if (empty($_POST['to']) || $_POST['to'] == $this->diafan->_users->id)
		{
			$this->result["errors"][0] = 'ERROR';
			return;
		}
		if (! empty($this->diafan->_route->show))
		{
			$_POST['to'] = $this->diafan->_route->show;
		}
		if (! $_POST["message"])
		{
			$this->result["errors"][0] = $this->diafan->_('Заполните поле «Cообщение».', false);
			return;
		}
		$_POST["message"] = $this->diafan->_bbcode->replace($_POST["message"]);
    }
}
