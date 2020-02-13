<?php
/**
 * Обработка запроса при отправке сообщения из формы подписки на рассылку
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

class Subscribtion_action extends Action
{
	/**
	 * Обрабатывает полученные данные из формы
	 * 
	 * @return void
	 */
	public function init()
	{
		if(empty($_POST['action']))
			return;

		if(empty($_POST['mail']))
		{
			$this->result["errors"]['mail'] = $this->diafan->_('Укажите e-mail.');
			return;
		}

		$row = DB::query_fetch_array("SELECT * FROM {subscribtion_emails} WHERE mail='%s' AND trash='0' LIMIT 1", $_POST['mail']);
		if($row["id"] && ($_POST['action'] != 'add' && $row['code'] != $_POST['code']))
		{
		    return FALSE;
		}

		if(! $row["id"])
		{
			$this->check_fields();

			if ($this->result())
				return;

			DB::query("INSERT INTO {subscribtion_emails} (mail, act, created, code) VALUES ('%s', '1', %d, '%s')", $_POST["mail"], time(), md5(rand(0, 9999999)));
			$row = DB::query_fetch_array("SELECT * FROM {subscribtion_emails} WHERE mail='%s' AND trash='0' LIMIT 1", $_POST['mail']);
			$this->send_mail($row["mail"], $row["code"]);
		}
		elseif(! $row["act"])
		{
			DB::query("UPDATE {subscribtion_emails} SET act='1' WHERE id=%d", $row["id"]);
			$this->send_mail($row["mail"], $row["code"]);
		}

		if($this->diafan->configmodules("cat", "subscribtion") && $_POST['action'] != 'add')
		{
			DB::query("DELETE FROM {subscribtion_emails_cat_unrel} WHERE element_id=%d", $row['id']);
			$rows_cat = DB::query_fetch_all("SELECT id FROM {subscribtion_category} WHERE trash='0' ORDER BY sort ASC");
			foreach ($rows_cat as $row_cat)
			{
				if(empty($_POST['cat_ids']) || ! in_array($row_cat['id'], $_POST['cat_ids']))
				{
				    DB::query("INSERT INTO {subscribtion_emails_cat_unrel} (element_id, cat_id) VALUES (%d, %d)", $row['id'], $row_cat['id']);
				}
			}
		}
		if($_POST['action'] == 'add')
		{
			$mes = $this->diafan->configmodules('add_mail', 'subscribtion');	
			$this->result["errors"][0] = $mes ? $mes : ' ';
			$this->result["result"] = 'success';
		}
		else
		{
			$this->result["errors"][0] = $this->diafan->_('Изменения сохранены.', false);
		}
	}

	/**
	 * Валидация введенных данных
	 * 
	 * @return void
	 */
	private function check_fields()
	{
		Custom::inc('includes/validate.php');

		$mes = Validate::mail($_POST['mail']);
		if ($mes)
		{
			$this->result["errors"]["mail"] = $this->diafan->_($mes);
		}
	}

	/**
	 * Уведомление пользователя по e-mail
	 * 
	 * @return void
	 */
	private function send_mail($mail, $code)
	{
		$url_subscribtion = BASE_PATH_HREF.$this->diafan->_route->module("subscribtion");
		$link    = $url_subscribtion.'?mail='.$mail.'&code='.$code;
		$actlink = $url_subscribtion.'?action=del&mail='.$mail.'&code='.$code;
	    
		$subject = str_replace(
			array('%title', '%url'),
			array(TITLE, BASE_URL),
			$this->diafan->configmodules("subject_user", 'subscribtion')
		);

		$message = str_replace(
			array('%title', '%url', '%link', '%actlink'),
			array(
				TITLE,
				BASE_URL,
				$link,
				$actlink				
			),
			$this->diafan->configmodules("message_user", 'subscribtion')
		);

		$to   = $mail;
		$from = $this->diafan->configmodules("emailconf", 'subscribtion')
		        ? $this->diafan->configmodules("email", 'subscribtion')
		        : '';

		Custom::inc('includes/mail.php');
		send_mail($to, $subject, $message, $from);
	}
}