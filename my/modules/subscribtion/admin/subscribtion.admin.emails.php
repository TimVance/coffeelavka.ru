<?php
/**
 * База электронных ящиков для рассылок
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
 * Subscribtion_admin_emails
 */
class Subscribtion_admin_emails extends Frame_admin
{
	/**
	 * @var string таблица в базе данных
	 */
	public $table = 'subscribtion_emails';
	
	/**
	 * @var string категории рассылок
	 */
	public $subscribtion = '';

	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'main' => array (
			'mail' => array(
				'type' => 'email',
				'name' => 'Почтовый ящик',
				'help' => 'Электронный адрес подписчика.',
			),
			'name' => array(
				'type' => 'text',
				'name' => 'Имя получателя',
				'help' => 'Можно добавить в рассылку тегом %name.',
			),
			'created' => array(
				'type' => 'datetime',
				'name' => 'Дата добавления',
				'help' => 'Дата добавления подписчика. Вводится в формате дд.мм.гггг чч:мм.',
			),
			'act' => array(
				'type' => 'checkbox',
				'name' => 'Получает рассылку',
				'help' => 'Позволяет отключить подписчика от рассылки. Пользователи, отписаннавшиеся от рассылки на сайте из базы данных не удаляются, только снимается отметка «Получает рассылку».',
			),
			'code' => array(
				'type' => 'none',
				'name' => 'Код управления рассылкой',
				'help' => 'Код, указанный пользователю в ссылке на управление рассылкой.',
			),
			'category' => array(
				'type' => 'function',
				'help' => 'Категории рассылок, на которые подписан пользователь. Параметр появляется, если отмечена опция «Использовать категории».',
			),
		),
	);

	/**
	 * @var array поля в списка элементов
	 */
	public $variables_list = array (
		'checkbox' => '',
		'created' => array(
			'name' => 'Дата и время',
			'type' => 'datetime',
			'sql' => true,
			'no_important' => true,
		),
		'name' => array(
			'name' => 'Почтовый ящик',
			'variable' => 'mail',
		),
		'actions' => array(
			'act' => true,
			'trash' => true,
		),
	);

	/**
	 * @var array поля для фильтра
	 */
	public $variables_filter = array (
		'mail' => array(
			'name' => 'Искать по почтовому ящику',
			'type' => 'text',
		),
	);

	/**
	 * Выводит ссылку на добавление
	 * @return void
	 */
	public function show_add()
	{
		$this->diafan->addnew_init('Добавить подписчика');
	}

	/**
	 * Выводит список рассылок
	 * @return void
	 */
	public function show()
	{
		$this->upload();

		$this->diafan->list_row();

		$this->form_upload();
	}
	
	/**
	 * Выводит список категорий рассылок
	 * @return void
	 */
	public function edit_variable_category()
	{
		if(!$this->diafan->configmodules("cat", "subscribtion"))
		{
			return TRUE;
		}
		else if($this->diafan->is_new)
		{
			$cat_unrel = array();
			$this->parent_id_subscribtion(0, '', array(), $cat_unrel);
			echo '<div class="unit" id="category"><div class="infofield">'.$this->diafan->_('Категории рассылок').'</div>'.$this->subscribtion.'</div>';
		}
		else
		{
			$row = DB::query_fetch_array("SELECT * FROM {subscribtion_emails} WHERE id=%d AND trash='0' LIMIT 1", $this->diafan->id);
			$cat_unrel = DB::query_fetch_value("SELECT cat_id FROM {subscribtion_emails_cat_unrel} WHERE element_id=%d AND trash='0'", $row['id'], "cat_id");
			$this->parent_id_subscribtion(0, '', array(), $cat_unrel);
			echo '<div class="unit" id="category"><div class="infofield">'.$this->diafan->_('Категории рассылок').'</div>'.$this->subscribtion.'</div>';
		}
	}
	
	/**
	 * Сохраняет список категорий рассылок
	 * @return void
	 */
	public function save_variable_category()
	{
		DB::query("DELETE FROM {subscribtion_emails_cat_unrel} WHERE element_id=%d", $this->diafan->id);
		
		$rows = DB::query_fetch_all("SELECT id FROM {subscribtion_category} WHERE trash='0'");
		foreach ($rows as $row)
		{
			if(empty($_POST['subscribtion_category']) || !in_array($row['id'], $_POST['subscribtion_category']))
			{
				DB::query("INSERT INTO {subscribtion_emails_cat_unrel} (element_id, cat_id) VALUES (%d, %d)", $this->diafan->id, $row['id']);
			}
		}
	}
	
	/**
	 * Формирует список рассылок
	 * @return array
	 */
	private function parent_id_subscribtion($parent_id, $rew, $array, $cat_unrel)
	{
		$rows = DB::query_fetch_all("SELECT [name], id FROM {subscribtion_category} WHERE parent_id=%d AND trash='0' ORDER BY sort ASC", $parent_id);		
		foreach ($rows as $row)
		{
			$this->subscribtion .= $rew.'<input type="checkbox" name="subscribtion_category[]" id="input_subscribtion_category_'.$row["id"].'" value="'.$row["id"].'"'
			.(!in_array($row['id'], $cat_unrel) ? ' checked' : '')
			.' class="label_full"> <label for="input_subscribtion_category_'.$row["id"].'">'.$row["name"].'</label>';
			if (in_array($row["id"], $array))
			{
				return $array;
			}
			$array[] = $row["id"];
			$array   = $this->parent_id_subscribtion($row["id"], '&nbsp;&nbsp;&nbsp;'.$rew, $array, $cat_unrel);
		}
		return $array;
	}
	
	/**
	 * Сохраняет код управления рассылкой
	 * @return void
	 */
	public function save_variable_code()
	{
		if(! $this->diafan->values("code"))
		{
			$this->diafan->set_query("code='%s'");
			$this->diafan->set_value(md5(rand(0, 9999999)));
		}
	}

	/**
	 * Сопутствующие действия при удалении элемента модуля
	 * @return void
	 */
	public function delete($del_ids)
	{
		$this->diafan->del_or_trash_where("subscribtion_emails_cat_unrel", "element_id IN (".implode(",", $del_ids).")");
	}

	/**
	 * Выводит форму импорт/экспорт ключевиков
	 * 
	 * @return void
	 */
	private function form_upload()
	{
		echo '
		<form action="" enctype="multipart/form-data" method="post" class="box box_half box_height">
			<input type="hidden" name="upload" value="true">
			<div class="box__heading">'.$this->diafan->_('Импорт').'</div>
			
			<input type="checkbox" name="delete_old" id="input_delete_old" value="1"> <label for="input_delete_old">'.$this->diafan->_('удалить неописанные в файле строки').'</label><br><br>
		
			<input type="file" class="file" name="file">
			
			<div class="box__warning">
				<i class="fa fa-warning"></i>
				'.$this->diafan->_('*файл .txt, каждый подписчик с новой строки в формате «Имя;mail@site.ru»').'
			</div>
			
			<button class="btn btn_blue btn_small">'.$this->diafan->_('Импортировать').'</button>
		</form>

		<div class="box box_half box_height box_right">
			<div class="box__heading">'.$this->diafan->_('Экспорт').'</div>
			
			<a href="'.BASE_PATH.'subscribtion/export/emails/?'.rand(0, 999999).'" class="file-load">
				<i class="fa fa-file-code-o"></i>
				'.$this->diafan->_('Скачать emails.txt').'
			</a>
		</div>';
	}

	/**
	 * Загружает файл перевода
	 * 
	 * @return void
	 */
	private function upload()
	{
		if (! empty($_GET["result"]))
		{
			if (empty($_GET["count_add"]) && empty($_GET["count_upd"]))
			{
				echo '<div class="error">'.$this->diafan->_('В файле не найден ни один корректный адрес.');
			}
			else
			{
				echo '<div class="ok">';
			}
			if (! empty($_GET["count_add"]))
			{
				echo $this->diafan->_('Добавлено новых адресов: %d.', $_GET["count_add"]).' ';
			}
			if (! empty($_GET["count_upd"]))
			{
				echo $this->diafan->_('Обновлено адресов: %d.', $_GET["count_upd"]);
			}
			echo '</div>';
		}
		if(! empty($_POST["delete_old"]))
		{
			DB::query("TRUNCATE TABLE {subscribtion_emails}");
		}
		if (! isset($_FILES["file"]) || ! is_array($_FILES["file"]) || $_FILES["file"]['name'] == '')
		{
			return;
		}
		$oldmails  = array();
		if(empty($_POST["delete_old"]))
		{
			$oldmails = DB::query_fetch_key_value("SELECT * FROM {subscribtion_emails} WHERE trash='0'", "mail", "id");
		}

		$file = file_get_contents($_FILES["file"]['tmp_name']);

		Custom::inc("includes/validate.php");

		$newmails = explode("\n", $file);
		$count_add = 0;
		$count_upd = 0;
		foreach ($newmails as $s)
		{
			if(! trim($s))
			{
				continue;
			}
			list($name, $mail) = explode(';', trim($s));
			if(Validate::mail($mail))
			{
				continue;
			}

			if(! empty($oldmails[$mail]))
			{
				DB::query("UPDATE {subscribtion_emails} SET act='1', name='%s' WHERE id=%d", $name, $oldmails[$mail]);
				$count_upd++;
			}
			else
			{
				DB::query("INSERT INTO {subscribtion_emails} (act, name, mail, created, code) VALUES ('1', '%s', '%s', %d, '%s')", $name, $mail, time(), md5(rand(0, 9999999)));
				$count_add++;
			}
		}
		unlink($_FILES["file"]['tmp_name']);

		$this->diafan->redirect(URL.'success1/?result=true&count_add='.$count_add.'&count_upd='.$count_upd);
	}

	/**
	 * Выводит системное сообщение
	 *
	 * @return void
	 */
	public function show_error_message()
	{
		if ($this->diafan->_route->error)
		{
			echo '<div class="error">'.$this->diafan->_('Файл не верного формата.').'</div>';
		}

		if ($this->diafan->_route->success)
		{
			echo '<div class="ok">'.$this->diafan->_('Изменения сохранены.').'</div>';
		}
	}
}