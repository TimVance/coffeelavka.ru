<?php
/**
 * Корзина с удаленными элементами
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
 * Trash_admin
 */
class Trash_admin extends Frame_admin
{
	/**
	 * @var string таблица в базе данных
	 */
	public $table = 'trash'; 

	/**
	 * @var array настройки отображения
	 */
	public $config = array(
		'datetime',	//показывать дату и время в списке
	);

	/**
	 * @var array дополнительные групповые операции
	 */
	public $group_action = array(
		"restore" => array('name' => "Восстановить")
	);

	/**
	 * @var array поля в списка элементов
	 */
	public $variables_list = array (
		'checkbox' => '',
		'plus' => array(),
		'created' => array(
			'name' => 'Дата и время',
			'type' => 'datetime',
			'no_important' => true,
			'sql' => true,
		),
		'element_id' => array(
			'sql' => true,
		),
		'module_name' => array(
			'sql' => true,
			'no_important' => true,
		),
		'table_name' => array(
			'sql' => true,
			'type' => 'none',
			'no_important' => true,
		),
		'user_id' => array(
			'sql' => true,
			'no_important' => true,
		),
		'restore' => array(),
		'actions' => array(
			'del' => true,
		),
	);

	/**
	 * Выводит список удаленных в коризун элементов
	 * @return void
	 */
	public function show()
	{
		$this->diafan->list_row();

		if (! $this->diafan->count)
		{
			echo '<p><b>'.$this->diafan->_('Корзина пуста.').'</b><br>'.$this->diafan->_('Удаленных элементов сайта нет.').'</p>';
		}
	}

	/**
	 * Фильтр вывода
	 *
	 * @return void
	 */
	public function show_module_contents()
	{
		if ($this->diafan->count)
		{
			echo '<p>
			<form action="" method="post">
			<input name="action" type="hidden" value="delete">
			<input name="all" type="hidden" value="true">
			<input name="check_hash_user" type="hidden" value="'.$this->diafan->_users->get_hash().'">
			<input type="button" class="trash_clear button" value="'.$this->diafan->_('Очистить корзину').'" confirm="'.$this->diafan->_('Вы действительно хотите удалить все элементы из корзины?').'">
			</form>
			</p>';
		}
	}

	/**
	 * Проверяет можно ли выполнять действия с текущим элементом строки
	 *
	 * @param array $row информация о текущем элементе списка
	 * @param string $action действие
	 * @return boolean
	 */
	public function check_action($row, $action = '')
	{
		// нельзя удалить из корзины элемент, который удален по взаимосвязи с другим
		if($row["parent_id"])
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Восстанавливает элементы из корзины
	 * @return void
	 */
	public function restore()
	{
		// Прошел ли пользователь проверку идентификационного хэша
		if (! $this->diafan->_users->checked)
		{
			$this->diafan->redirect(URL);
		}

		if (! empty($_POST["id"]))
		{
			$ids = array($_POST["id"]);
		}
		else
		{
			$ids = $_POST["ids"];
		}
		foreach ($ids as $id)
		{
			$id = intval($id);
			$this->restore_id($id);
		}

		$this->diafan->redirect(URL);
	}

	/**
	 * Восстанавливает элемент из корзины
	 * 
	 * @param integer $id номер восстанавливаемого элемента
	 * @return void
	 */
	private function restore_id($id)
	{
		$row = DB::query_fetch_array("SELECT table_name, element_id, module_name, id FROM {trash} WHERE id=%d LIMIT 1", $id);

		if (! $row)
		{
			return;
		}

		//проверка прав пользователя на удаление
		if (! $this->diafan->_users->roles('del', $row["module_name"]))
		{
			return;
		}
		$this->diafan->_cache->delete('', $row["module_name"]);

		$this->restore_elements($row["table_name"], $row["element_id"], $row["id"]);
	}

	/**
	 * Восстанавливает связанные элементы из корзины
	 *
	 * @param string $table название таблицы
	 * @param integer $id номер восстанавливаемого элемента
	 * @param integer $trash_id номер записи в корзине
	 * @return void
	 */
	private function restore_elements($table, $id, $trash_id)
	{
		DB::query("UPDATE {".$table."} SET trash='0' WHERE id=%d", $id);
		DB::query("DELETE FROM {trash} WHERE id=%d", $trash_id);
		DB::query("DELETE FROM {trash_parents} WHERE parent_id=%d AND element_id=%d", $trash_id, $trash_id);

		$rows = DB::query_fetch_all("SELECT element_id, table_name,id FROM {trash} WHERE parent_id=%d", $trash_id);

		foreach ($rows as $row)
		{
			$this->restore_elements($row["table_name"], $row["element_id"], $row["id"]);
		}
		if (strpos($table, '_parents') === false)
		{
			$del_row = DB::query_fetch_array("SELECT * FROM {".$table."} WHERE id=%d LIMIT 1", $id);
			if (! empty($del_row["parent_id"]))
			{
				$count = DB::query_result("SELECT COUNT(*) FROM {".$table."} WHERE trash='0' AND parent_id=%d", $del_row["parent_id"]);
				DB::query("UPDATE {".$table."} SET count_children=%d WHERE id=%d", $count, $del_row["parent_id"]);
			}
		}
		$this->include_modules('restore_from_trash', array($table, $id));
	}

	/**
	 * Удаляет элемент или элементы из корзины
	 * @return void
	 */
	public function del()
	{
		// Прошел ли пользователь проверку идентификационного хэша
		if (! $this->diafan->_users->checked)
		{
			$this->diafan->redirect(URL);
		}
		// очистка корзины
		if(! empty($_POST["all"]))
		{
			$rows = DB::query_fetch_all("SELECT table_name, element_id, id FROM {trash} WHERE parent_id=0");
			foreach ($rows as $row)
			{
				$this->diafan->del_from_trash($row["table_name"], $row["element_id"], $row["id"]);
			}
			$this->diafan->redirect(URL.'success1/');
		}

		if (! empty($_POST["id"]))
		{
			$ids = array($_POST["id"]);
		}
		else
		{
			$ids = $_POST["ids"];
		}
		foreach ($ids as $id)
		{
			$id = intval($id);
			$this->del_id($id);
		}

		$this->diafan->redirect(URL);
	}

	/**
	 * Удаляет элемент из корзины
	 * 
	 * @param integer $id номер удаляемого элемента
	 * @return void
	 */
	private function del_id($id)
	{
		$row = DB::query_fetch_array("SELECT table_name, element_id, id FROM {trash} WHERE id=%d LIMIT 1", $id);

		if (! $row)
		{
			return;
		}
		$this->diafan->del_from_trash($row["table_name"], $row["element_id"], $row["id"]);
	}

	/**
	 * Выводит название удаленного объекта в списке
	 * 
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return string
	 */
	public function list_variable_element_id($row, $var)
	{
		$data = '<div class="name">';
		switch($row["table_name"])
		{
			case "images":
				$image_row = DB::query_fetch_array("SELECT name, module_name FROM {".$row["table_name"]."} WHERE id=%d LIMIT 1", $row["element_id"]);

				if ($image_row && file_exists(ABSOLUTE_PATH.USERFILES."/".$image_row["module_name"]."/small/".$image_row["name"]))
				{
					$data .= '<img src="http'.(IS_HTTPS ? "s" : '').'://'.BASE_URL.'/'.USERFILES.'/'.$image_row["module_name"]."/small/".$image_row["name"].'" border="0">';
				}
				break;

			case "users":
				$user = DB::query_fetch_array("SELECT fio, name FROM {".$row["table_name"]."} WHERE id=%d LIMIT 1", $row["element_id"]);
				$data .= $user["fio"].' ('.$user["name"].')';
				break;

			case "tags":
				$text = DB::query_result("SELECT [name] FROM {tags_name} WHERE id IN ("
							." SELECT tags_name_id FROM {".$row["table_name"]."} WHERE id=%d) LIMIT 1", $row["element_id"]);
				$data .= ($text ? $this->diafan->short_text($text) : $row["element_id"]);
				break;

			case "rating":
				$rating = DB::query_result("SELECT rating FROM {".$row["table_name"]."} WHERE id=%d LIMIT 1", $row["element_id"]);
				$data .= ($rating ? $rating : $row["element_id"]);
				break;

			case "feedback":
				$data .= $this->diafan->_('Сообщение из формы обратной связи');
				break;

			case "feedback_param_element":
				$param = DB::query_fetch_array("SELECT param_id, value FROM {".$row["table_name"]."} WHERE id=%d LIMIT 1", $row["element_id"]);
				$param_name = DB::query_result("SELECT [name] FROM {feedback_param} WHERE id=%d LIMIT 1", $param["param_id"]);
				$data .= $param_name.': '.$param["value"];
				break;

			case "shop_order":
				$data .= $this->diafan->_('Заказ №').' '.$row["element_id"];
				break;

			case "shop_discount":
				$discount = DB::query_result("SELECT discount FROM {shop_discount} WHERE id=%d LIMIT 1", $row["element_id"]);
				$data .= $this->diafan->_('Скидка').' '.$discount.'%';
				break;

			case "shop_rel":
				$data .= $this->diafan->_('Связи между товарами');
				break;

			case "shop_param_element":
				$param = DB::query_fetch_array("SELECT param_id, [value] FROM {".$row["table_name"]."} WHERE id=%d LIMIT 1", $row["element_id"]);
				$param_name = DB::query_result("SELECT [name] FROM {shop_param} WHERE id=%d LIMIT 1", $param["param_id"]);
				$data .= $param_name.': '.$param["value"];
				break;

			case "rewrite":
				$data .= $this->diafan->_('Псевдоссылка');
				break;

			default:
				$element = DB::query_fetch_array("SELECT * FROM {".$row["table_name"]."} WHERE id=%d LIMIT 1", $row["element_id"]);
				$name = $row["element_id"];
				if (! empty($element["name"]))
				{
					$name = $element["name"];
				}
				elseif (! empty($element["name"._LANG]))
				{
					$name = $element["name"._LANG];
				}
				elseif (! empty($element["text"]))
				{
					$name = $this->diafan->short_text($element["text"], 50);
				}
				elseif (! empty($element["text"._LANG]))
				{
					$name = $this->diafan->short_text($element["text"._LANG], 50);
				}
				if ($row["table_name"] == "shop_price")
				{
					return $element["price"].' '.$this->diafan->configmodules("currency", "shop");
				}
				elseif (strpos($row["table_name"], '_parents') !== false)
				{
					$name = $this->diafan->_('Родительские связи');
				}
				elseif (strpos($row["table_name"], '_category_rel') !== false)
				{
					$name = $this->diafan->_('Связи с категориями');
				}
				$data .= $name;
		}
		return $data.'</div>';
	}

	/**
	 * Выводит название модуля удаленного объекта в списке
	 * 
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return string
	 */
	public function list_variable_module_name($row, $var)
	{
		if(! empty($this->diafan->title_modules[$row["module_name"]]))
		{
			$name = $this->diafan->title_modules[$row["module_name"]];
		}
		else
		{
			$name = $row["table_name"];
		}
		return '<div class="no_important">'.$name
		.'</div>';
	}

	/**
	 * Выводит название модуля удаленного объекта в списке
	 * 
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return string
	 */
	public function list_variable_restore($row, $var)
	{
		return '<div class="sum">'.(! $row["parent_id"] ? '<a href="javascript:void(0)" action="restore" class="action">'.$this->diafan->_('Восстановить').'</a>':'')
		.'</div>';
	}

	/**
	 * Выводит имя пользователя, удалившего элемент
	 * 
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return string
	 */
	public function list_variable_user_id($row, $var)
	{
		if(! isset($this->cache["prepare"]["users"]))
		{
			$user_ids = array();
			foreach($this->diafan->rows as $r)
			{
				if(! $r["parent_id"] && $r["user_id"] && ! in_array($r["user_id"], $user_ids))
				{
					$user_ids[] = $r["user_id"];
				}
			}
			if($user_ids)
			{
				$this->cache["prepare"]["users"] = DB::query_fetch_key_value(
					"SELECT id, CONCAT(fio, ' (', name, ')') as fio FROM {users} WHERE id IN (%s) AND trash='0'",
					implode(",", $user_ids),
					"id", "fio"
				);
			}
		}
		$text = '<div class="no_important">';
		if(! $row["parent_id"] && $row["user_id"] && ! empty($this->cache["prepare"]["users"][$row["user_id"]]))
		{
			$text .= '<a href="'.BASE_PATH_HREF.'users/edit'.$row["user_id"].'/">'.$this->cache["prepare"]["users"][$row["user_id"]].'</a>';
		}
		$text .= '</div>';
		return $text;
	}
}