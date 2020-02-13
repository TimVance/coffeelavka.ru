<?php
/**
 * Редактирование отзывов
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
 * Reviews_admin
 */
class Reviews_admin extends Frame_admin
{
	/**
	 * @var string таблица в базе данных
	 */
	public $table = 'reviews';

	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'main' => array (
			'created' => array(
				'type' => 'datetime',
				'name' => 'Дата добавления',
				'help' => 'В формате дд.мм.гггг чч:мм.',
			),
			'user_id' => array(
				'type' => 'function',
				'name' => 'Пользователь',
				'help' => 'Пользователь, добавивший отзыв (если отзыв добавлен зарегистрированным пользователем).',
			),
			'param' => array(
				'type' => 'function',
				'name' => 'Дополнительные поля',
				'help' => 'Поля, добавленные в конструкторе формы.',
			),
			'act' => array(
				'type' => 'checkbox',
				'name' => 'Опубликовать на сайте',
				'help' => 'Если не отмечена, отзыв не будет виден на сайте.',
				'default' => true,
			),
			'hr2' => 'hr',
			'element_id' => array(
				'type' => 'function',
				'name' => 'Отзыв к',
				'help' => 'Объект, к которому прикреплены отзывы, ссылка на все отзывы к этой странице.',
				'disabled' => true,
			),
			'readed' => array(
				'type' => 'function',
				'name' => 'Помечает как прочитанное',
				'hide' => true,
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
		'param' => array(
			'name' => 'Отзыв',
			'type' => 'text',
			'class' => 'text',
			'no_important' => true,
		),
		'element_id' => array(
			'sql' => true,
			'no_important' => true,
		),
		'element_type' => array(
			'sql' => true,
			'type' => 'none',
			'no_important' => true,
		),
		'module_name' => array(
			'sql' => true,
			'no_important' => true,
		),
		'adapt' => array(
			'class_th' => 'item__th_adapt',
		),
		'separator' => array(
			'class_th' => 'item__th_seporator',
		),				
		'actions' => array(
			'act' => true,
			'trash' => true,
		),
	);

	/**
	 * Выводит контент модуля
	 * 
	 * @return void
	 */
	public function show()
	{
		if(! empty($_GET["rew"]))
		{
			$res = explode('/', $_GET["rew"]);
			if(count($res) == 3)
			{
				$this->diafan->get_nav .= ($this->diafan->get_nav ? '&' : '?').'rew='.$this->diafan->filter($_GET, "url", "rew");
				$this->diafan->where = " AND module_name='".$this->diafan->filter($res[0], "sql")."' AND element_id=".$this->diafan->filter($res[2], "int")." AND element_type='".$this->diafan->filter($res[1], "sql")."'";
			}
		}

		$this->diafan->list_row();	
		
		if (! $this->diafan->count)
		{
			echo '<p><b>'.$this->diafan->_('Отзывов нет.').'</b><br>'.$this->diafan->_('Отзывы оставляются посетителями из пользовательской части сайта.').'</p>';
		}
	}

	/**
	 * Выводит дополнительные поля в списке
	 *
	 * @return string
	 */
	public function list_variable_param($row)
	{
		if(! isset($this->cache["prepare"]["param"]))
		{
			$select = array();
			$checkbox = array();
			$rows = DB::query_fetch_all("SELECT e.element_id, e.value, e.param_id, p.type, p.[name] FROM"
				." {reviews_param_element} AS e"
				." INNER JOIN {reviews_param} AS p ON e.param_id=p.id"
				. " WHERE e.trash='0' AND e.element_id IN (%s)", implode(",", $this->diafan->rows_id));
			foreach ($rows as $r)
			{
				switch ($r["type"])
				{
					case 'select':
					case 'multiple':
						if(! in_array($r["value"], $select))
						{
							$select[] = $r["value"];
						}
						break;

					case 'checkbox':
						if(! in_array($r["param_id"], $checkbox))
						{
							$checkbox[] = $r["param_id"];
						}
						break;
				}
			}
			if($select)
			{
				$select_value = DB::query_fetch_key_value("SELECT id, [name] FROM {reviews_param_select} WHERE id IN (%s)", implode(",", $select), "id", "name");
			}
			if($checkbox)
			{
				$checkbox_value = DB::query_fetch_key_value("SELECT param_id, [name] FROM {reviews_param_select} WHERE param_id IN (%s)", implode(",", $checkbox), "param_id", "name");
			}
			foreach ($rows as $r)
			{
				if ($r["value"])
				{
					switch ($r["type"])
					{
						case 'select':
						case 'multiple':
							if(! empty($select_value[$r["value"]]))
							{
								$r["value"] = $select_value[$r["value"]];
							}
							break;
	
						case 'checkbox':
							$v = (! empty($checkbox_value[$r["param_id"]]) ? $checkbox_value[$r["param_id"]] : '');
							if ($v)
							{
								$r["value"] = $r["name"].': '.$v;
							}
							else
							{
								$r["value"] = $r["name"];
							}
							break;
					}
					$this->cache["prepare"]["param"][$r["element_id"]][] = $r["value"];
				}
			}
		}
		$text = '<div class="name"><a href="'.$this->diafan->get_base_link($row).'">';
		if(! empty($this->cache["prepare"]["param"][$row["id"]]))
		{
			$text .= implode(', ', $this->cache["prepare"]["param"][$row["id"]]);
		}
		else
		{
			$text .= $row["id"];
		}
		$text .= '</a></div>';
		return $text;
	}

	/**
	 * Выводит объект, к которому прикреплен отзыв, в списке
	 * 
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return string
	 */
	public function list_variable_element_id($row, $var)
	{
		if (empty($this->cache["elements"][$row["module_name"]][$row["element_type"]][$row["element_id"]]))
		{
			$table = $this->diafan->table_element_type($row["module_name"], $row["element_type"]);
			$name = DB::query_result("SELECT ".($row["module_name"] != 'faq' ? '[name]' : '[anons]')." FROM {".$table."} WHERE id=%d LIMIT 1", $row["element_id"]);
			$name = $this->diafan->short_text($name);
			$this->cache["elements"][$row["module_name"]][$row["element_type"]][$row["element_id"]] = ($name ? $name : $row["element_id"]);
		}
		return '<div class="no_important">'.$this->cache["elements"][$row["module_name"]][$row["element_type"]][$row["element_id"]].'</div>';
	}

	/**
	 * Выводит название модуля в списке
	 * 
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return string
	 */
	public function list_variable_module_name($row, $var)
	{
		if(! empty($this->diafan->title_modules[$row["module_name"]]))
		{
			$row["module_name"] = $this->diafan->title_modules[$row["module_name"]];
		}
		return '<div class="no_important">'.$this->diafan->_($row["module_name"])
		.($row["element_type"] == 'cat' ? ', '.$this->diafan->_('категория') : '')
		.'</div>';
	}

	/**
	 * Редактирование поля "Объект"
	 * 
	 * @return void
	 */
	public function edit_variable_element_id()
	{
		$element_type = $this->diafan->element_type();

		$link = BASE_PATH.$this->diafan->_route->link(0, $this->diafan->value, $this->diafan->values("module_name"), $this->diafan->values("element_type"));

		echo '
		<div class="unit">
			<b>'.$this->diafan->variable_name().'</b>
			<a href="'.$link.'" target="_blank">'.$link.'</a>'.$this->diafan->help().'
			<br>
			('.$this->diafan->_('Посмотреть').' <a href="'.$this->diafan->get_admin_url('page').'?rew='.$this->diafan->values("module_name").'/'.$element_type.'/'.$this->diafan->value.'">'.$this->diafan->_('все отзывы').'</a> '.$this->diafan->_('к этому объекту').')
		</div>';
	}

	/**
	 * Редактирование поля "Дополнительные параметры"
	 * 
	 * @return void
	 */
	public function edit_variable_param()
	{
		parent::__call('edit_variable_param', array("AND (module_name='".$this->diafan->values("module_name")."' OR module_name='')"));
	}

	/**
	 * Редактирование поля "Помечает как прочитанное"
	 *
	 * @return void
	 */
	public function edit_variable_readed()
	{
		if(! $this->diafan->value && ! $this->diafan->is_new)
		{
			DB::query("UPDATE {reviews} SET readed='1' WHERE id=%d", $this->diafan->id);
		}
		echo '<input name="readed" value="1" type="hidden">';
	}

	/**
	 * Сохранение поля "Дополнительные параметры"
	 * 
	 * @return void
	 */
	public function save_variable_param()
	{
		parent::__call('save_variable_param', array(" AND (module_name='' OR module_name='".$this->diafan->values("module_name")."')"));
	}
}