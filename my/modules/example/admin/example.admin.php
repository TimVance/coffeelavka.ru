<?php
/**
 * Редактирование статей
 * 
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://cms.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2014 OOO «Диафан» (http://diafan.ru)
 */
if (!defined('DIAFAN'))
{
    include dirname(dirname(dirname(__FILE__))).'/includes/404.php';
}

/**
 * Example_admin
 */
class Example_admin extends Frame_admin
{
	/**
	 * @var string таблица в базе данных
	 */
	public $table = 'example';

	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'main' => array (
			'created' => array(
				'type' => 'datetime',
				'name' => 'Дата создания',
			),
			'user_id' => array(
				'type' => 'select',
				'name' => 'Автор',
			),
			'text' => array(
				'type' => 'editor',
				'name' => 'Текст объявления',
			),
		),
	);

	/**
	 * @var array настройки модуля
	 */
	public $config = array (
		'act', // показать/скрыть
		'del', // удалить
		'datetime', // показывать дату в списке, сортировать по дате
		'trash', // использовать корзину
		'order', // сортируется
	);

	/**
	 * @var array списки из таблицы
	 */
	public $select = array(
		'user_id' => array(
			'users',
			'id',
			'fio',
			'',
			'',
			"trash='0'",
		),
	);

	/**
	 * @var array выводить в списке содержание полей:
	 */
	public $config_other_row = array(
		'user_id' => 'function',
	);

	/**
	 * @var array текст для ссылки на редактирование в списке
	 */
	public $text_for_base_link = array(
		'variable' => 'text'
	);

	/**
	 * Подготавливает конфигурацию модуля
	 * @return void
	 */
	public function prepare_config()
	{
		if(! empty($_GET['user']))
		{
			$this->diafan->where = " AND user_id='".$this->diafan->filter($_GET, 'sql', 'user')."'";
		}
	}

	/**
	 * Выводит ссылку на добавление
	 * @return void
	 */
	public function show_add()
	{
		$this->diafan->addnew_init('Добавить объявление');
	}

	/**
	 * Выводит контент модуля
	 * 
	 * @return void
	 */
	public function show()
	{
		$users = DB::query_fetch_all("SELECT id, fio FROM {users} WHERE trash='0' ORDER BY fio ASC");
		echo '<form method="GET">'.$this->diafan->_('Пользователь').':
			<select name="user">
				<option value="">'.$this->diafan->_('Все').'</option>';
				foreach($users as $user)
				{
					echo '<option value="'.$user["id"].'">'.$user["fio"].'</option>';
				}
			echo '</select>
			<input type="submit" value="OK">
		</form>';

		// список объявлений
		$this->diafan->list_row();
	} 

	/**
	 * Выводит имя пользователя в списке
	 * @return void
	 */
	public function other_row_user_id($row)
	{
		return '<td>'.DB::query_result("SELECT name FROM {users} WHERE id=%d", $row['user_id']).'</td>';
	}

	/**
	 * Редактирование поля "Пользователь"
	 * @return void
	 */
	public function edit_variable_user_id()
	{
	    echo '<tr>
	        <td class="td_first">Нажми</td>
	        <td><div class="user_id" rel="'.$this->diafan->value.'"><b>ЗДЕСЬ</b></div></td>
	    </tr>';
	}

	/**
	 * Сохранение поля "Пользователь"
	 * @return void
	 */
	public function save_variable_user_id()
	{
		$this->diafan->set_query("user_id=%d");
		$this->diafan->set_value(1);
	}
}