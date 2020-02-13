<?php
/**
 * Темы
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
 * Custom_admin
 */
class Custom_admin extends Frame_admin
{
	/**
	 * @var string таблица в базе данных
	 */
	public $table = 'custom';

	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'main' => array (
			'name' => array(
				'type' => 'text',
				'name' => 'Тема (латинские буквы)',
				'help' => 'Латинские буквы в нижнем регистре, нижнее подчеркивание или цифры.',
			),
			'current' => array(
				'type' => 'checkbox',
				'name' => 'Применить',
				'help' => 'Можно применить сразу несколько тем.',
			),
			'import' => array(
				'type' => 'function',
				'name' => 'Импорт темы',
				'help' => 'Файлы и папки из текущей темы будут удалены.',
			),
			'created' => array(
				'type' => 'datetime',
				'name' => 'Дата создания',
				'help' => 'Вводится в формате дд.мм.гггг чч:мм.',
			),
			'text' => array(
				'type' => 'textarea',
				'name' => 'Примечание',
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
			'name' => 'Тема',
			'class' => 'text',
		),
		'current' => array(
			'sql' => true,
			'fast_edit' => true,
		),
		'adddemo' => array(),
		'download' => array(),
		'text' => array(
			'sql' => true,
			'type' => 'text',
			'class' => 'text',
			'no_important' => true,
		),
		'actions' => array(
			'del' => true,
		),
	);

	/**
	 * Выводит ссылку на добавление
	 * @return void
	 */
	public function show_add()
	{
		echo '<p><a class="btn" href="?action=custom_generate">'.$this->diafan->_('Сгенерировать тему').'</a> ';
		echo ' <a href="'.BASE_PATH_HREF.'custom/addnew1/" class="btn btn_blue">'.$this->diafan->_('Добавить вручную').'</a>';
		if(IS_DEMO)
		{
			echo ' ('.$this->diafan->_('не доступно в демонстрационном режиме').')';
		}
		echo '</p>';
	}

	/**
	 * Выводит контент модуля
	 * @return void
	 */
	public function show()
	{
		if(! empty($_GET["action"]))
		{
			switch($_GET["action"])
			{
				case "custom_generate":
					$this->generate();
					break;

				case "custom_generate_demo":
					$this->generate_demo();
					break;
			}
		}

		$this->diafan->list_row();
	}

	/**
	 * Формирует SQL-запрос для списка элементов
	 *
	 * @param integer $id родитель
	 * @return array
	 */
	public function sql_query($id)
	{
		$rows = array();
		$rs = parent::sql_query($id);
		foreach(Custom::names() as $name)
		{
			foreach($rs as $r)
			{
				if($r["name"] == $name)
				{
					$rows[] = $r;
				}
			}
		}
		foreach($rs as $r)
		{
			if(! in_array($r["name"], Custom::names()))
			{
				$rows[] = $r;
			}
		}
		return $rows;
	}

	/**
	 * Функция быстрого редактирования текущей темы
	 *
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return void
	 */
	public function list_variable_current($row, $var)
	{
		$current = in_array($row["name"], Custom::names());
		$attr = '';
		if(file_exists(ABSOLUTE_PATH.'custom/'.$row["name"].'/install.sql'))
		{
			$attr = ' install_sql="'.$this->diafan->_('Внимание! Будут произведены необратимые изменения базы данных. Применить изменения?').'"';
		}
		$text = '<div class="text fast_edit_current">
		<input type="checkbox" name="current" row_id="'.$row["id"].'" id="current_'.$row["id"].'" value="1"'.($current ? ' checked' : '').$attr.'>
		<label for="current_'.$row["id"].'">'.$this->diafan->_('Применить').'</label>
		</div>';
		return $text;
	}
	
	/**
	 * Ссылка на добавление демо
	 *
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return void
	 */
	public function list_variable_adddemo($row, $var)
	{
		$text = '<div class="text">';
		
		if(in_array($row["name"], Custom::names()))
		{
			$text .=  '<a href="?action=custom_generate_demo&name='.$row["name"].'">';
			if(! file_exists(ABSOLUTE_PATH.'custom/'.$row["name"].'/install.sql'))
			{
				$text .= '<i class="fa fa-plus-square"></i> '.$this->diafan->_('Добавить контент');
			} 
			else 
			{
				$text .= '<i class="fa fa-check-circle"></i> '.$this->diafan->_('Обновить контент');
			}
			
			$text .='</a>';
			if(IS_DEMO)
			{
				$text .=  ' ('.$this->diafan->_('не доступно в демонстрационном режиме').')';
			}
		}
		
		return $text.'</div>';
	}
	

	/**
	 * Функция быстрого сохранения текущей темы
	 * @return boolean
	 */
	public function fast_save_current()
	{
		$name = DB::query_result("SELECT name FROM {custom} WHERE id=%d LIMIT 1", $_POST["id"]);

		$names = Custom::names();
		if(! empty($_POST["value"]))
		{
			if(! in_array($name, $names))
			{
				$names[] = $name;
			}
			if(! empty($_POST["install_sql"]))
			{
				$this->install_sql($name);
			}
		}
		else
		{
			$new_names = array();
			foreach($names as $n)
			{
				if($n != $name)
				{
					$new_names[] = $n;
				}
			}
			$names = $new_names;
		}


		$new_values = array('CUSTOM' => implode(',', $names));
		Custom::inc('includes/config.php');
		Config::save($new_values, $this->diafan->_languages->all);

		return true;
	}

	/**
	 * Ссылка на скачивание темы в списке тем
	 *
	 * @param array $row информация о текущем элементе списка
	 * @param array $var текущее поле
	 * @return void
	 */
	public function list_variable_download($row, $var)
	{
		$text = '<div class="text">';
		
		if (is_dir(ABSOLUTE_PATH.'custom/'.$row["name"]) && $dir = opendir(ABSOLUTE_PATH.'custom/'.$row["name"]))
		{
			while (($file = readdir($dir)) !== false)
			{
				if ($file != '.' && $file != '..')
				{
					$text .= '<a href="'.BASE_PATH.'custom/export/'.$row["id"].'/">'.$this->diafan->_('Скачать в Zip').'</a>';
					break;
				}
			}
			closedir($dir);
		}	
		
		return $text.'</div>';
	}
	
	/**
	 * Проверка поля "Применить"
	 * 
	 * @return void
	 */
	public function edit_variable_current()
	{
		$value = in_array($this->diafan->values("name"), Custom::names());
		$this->diafan->show_table_tr_checkbox('current', $this->diafan->variable_name(), $value, $this->diafan->help(), false);
	}
	
	/**
	 * Проверка поля "Импорт"
	 * 
	 * @return void
	 */
	public function edit_variable_import()
	{
		echo '
		<div class="unit" id="import">
			<div class="infofield">'.$this->diafan->variable_name().'</div>';
		if(defined('IS_DEMO') && IS_DEMO)
		{
			echo '<p>'.$this->diafan->_('В демонстрационном режиме эта функция не доступна.').'</p>';
		}
		echo '<input type="file" name="import" class="file">'.$this->diafan->help().'
		</div>';
	}

	/**
	 * Проверка поля "Название"
	 * 
	 * @return void
	 */
	public function validate_variable_name()
	{
		if(empty($_POST["name"]))
		{
			$this->diafan->set_error("name", "Название темы не должно быть пустым.");
		}
		elseif(preg_match('/[^a-z_0-9+]/', $_POST["name"]))
		{
			$this->diafan->set_error("name", "Название темы должно содержать только буквы латинского алфавита в нижнем регистре, цифры и нижнее подчеркивание.");
		}
		else
		{
			if(DB::query_result("SELECT id FROM {custom} WHERE name='%s'".(! $this->diafan->is_new ? " AND id<>%d" : ""), $_POST["name"], $this->diafan->id))
			{
				$this->diafan->set_error("name", "Тема с таким названием существует.");
			}
		}
	}

	/**
	 * Проверка поля "Импорт"
	 * 
	 * @return void
	 */
	public function validate_variable_import()
	{
		if(! isset($_POST["install_sql"]))
		{
			if(! empty($_POST["current"]) && ! $this->diafan->values('current') && file_exists(ABSOLUTE_PATH.'custom/'.$_POST["name"].'/install.sql'))
			{
				$this->diafan->set_error("install_sql", 'Внимание! Будут произведены необратимые изменения базы данных. Применить изменения?');
			}
		}
		if (isset($_FILES["import"]) && is_array($_FILES["import"]) && $_FILES["import"]['name'] != '')
		{
			if(! class_exists('ZipArchive'))
			{
				$this->diafan->set_error("import", 'Не доступно PHP-расширение ZipArchive. Обратитесь в техническую поддержку хостинга.');
			}
			$zip = new ZipArchive;
			if ($zip->open($_FILES['import']['tmp_name']) === true)
			{
				for($i = 0; $i < $zip->numFiles; $i++)
				{
					if($zip->getNameIndex($i) == '/install.sql' || $zip->getNameIndex($i) == 'install.sql')
					{
						$this->diafan->set_error("install_sql", 'Внимание! Будут произведены необратимые изменения базы данных. Применить изменения?');
						break;
					}
				}
				$zip->close();
			}
			else
			{
				$this->diafan->set_error("import", "Файл должен быть в формате ZIP.");
			}
		}
	}

	/**
	 * Сохранение поля "Пользователь"
	 * 
	 * @return void
	 */
	public function save_variable_current()
	{
		$edit = false;
		$names = Custom::names();
		if (! empty($_POST["current"]))
		{
			if(! in_array($_POST["name"], $names))
			{
				$edit = true;
				$names[] = $_POST["name"];
			}
		}
		else
		{
			$new_names = array();
			foreach($names as $n)
			{
				if($n != $_POST["name"])
				{
					$new_names[] = $n;
				}
				else
				{
					$edit = true;
				}
			}
			$names = $new_names;
		}
		if($edit)
		{
			$new_values = array('CUSTOM' => implode(',', $names));
			Custom::inc('includes/config.php');
			Config::save($new_values, $this->diafan->_languages->all);
		}
	}

	/**
	 * Сохранение поля "Название"
	 * 
	 * @return void
	 */
	public function save_variable_name()
	{
		$_POST["name"] = preg_replace('/[^a-z_0-9+]/', '', $_POST["name"]);
		$name = $_POST["name"];
		if(! defined('IS_DEMO') || ! IS_DEMO)
		{
			if($this->diafan->is_new)
			{
				File::create_dir('custom/'.$name);
			}
			elseif($this->diafan->values("name") != $name)
			{
				if($this->diafan->values("name") && is_dir(ABSOLUTE_PATH.'custom/'.$this->diafan->values("name")))
				{
					File::rename_dir($name, $this->diafan->values("name"), 'custom');
				}
				else
				{
					File::create_dir('custom/'.$name);
				}
			}
		}
		$this->diafan->set_query("name='%s'");
		$this->diafan->set_value($name);
	}

	/**
	 * Сохранение поля "Импорт"
	 * 
	 * @return void
	 */
	public function save_variable_import()
	{
		if(defined('IS_DEMO') && IS_DEMO)
		{
			return;
		}
		if (isset($_FILES["import"]) && is_array($_FILES["import"]) && $_FILES["import"]['name'] != '')
		{
			//File::delete_dir('custom/'.$_POST["name"]);
			File::create_dir('custom/'.$_POST["name"]);
			if(class_exists('ZipArchive'))
			{
				$paths = array();
				$zip = new ZipArchive;
				if ($zip->open($_FILES['import']['tmp_name']) === true)
				{
					for($i = 0; $i < $zip->numFiles; $i++)
					{
						$name = $zip->getNameIndex($i);
						if($name && substr($name, 0, 1) != '/')
						{
							$name = '/'.$name;
						}
						if(substr($name, -1) == '/')
						{
							$arr = explode('/', $name);
							array_pop($arr);
							$name = array_pop($arr);
							File::create_dir('custom/'.$_POST["name"].($arr ? '/'.implode('/', $arr) : '').'/'.$name);
						}
						else
						{
							File::save_file($zip->getFromName($zip->getNameIndex($i)), 'custom/'.$_POST["name"].$name);
						}
					}
					$zip->close();
				}
			}
		}
		if(! empty($_POST["install_sql"]))
		{
			$this->install_sql($_POST["name"]);
		}
	}

	/**
	 * Удаление темы
	 * 
	 * @return void
	 */
	public function del()
	{
		// Прошел ли пользователь проверку идентификационного хэша
		if (! $this->diafan->_users->checked)
		{
			$this->diafan->redirect(URL);
			return;
		}

		if (! $this->diafan->_users->roles('del', $this->diafan->_admin->rewrite))
		{
			$this->diafan->redirect(URL);
			return;
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
			if(! defined('IS_DEMO') || ! IS_DEMO)
			{
				if($name = DB::query_result("SELECT name FROM {custom} WHERE id=%d", $id))
				{
					File::delete_dir('custom/'.$name);
				}
			}
			DB::query("DELETE FROM {custom} WHERE id=%d", $id);
		}
		$this->diafan->redirect(BASE_PATH_HREF.'custom/success1/');
	}

	/**
	 * Генерирование темы
	 * 
	 * @return void
	 */
	public function generate()
	{
		if(IS_DEMO)
		{
			throw new Exception('В демонстрационном режиме эта функция не доступна.');
		}
		$count = $this->diafan->_custom->generate();
		if(! $count)
		{
			echo '<div class="error">';
			echo $this->diafan->_('Тема не сгенерирована. Нет кастомизированных файлов.');
		}
		else
		{
			echo '<div class="ok">';
			echo $this->diafan->_('Тема сгенерирована.');
			if($count["custom"])
			{
				echo $this->diafan->_('<br>Кастомизированные файлы:');
				echo '<div style="margin-left: 20px">'.implode('<br>',$count["custom"]).'</div>';
			}
			if($count["return"])
			{
				echo $this->diafan->_('<br>Восстановленные файлы:');
				echo '<div style="margin-left: 20px">'.implode('<br>',$count["return"]).'</div>';
			}
		}
		echo '</div>';
	}

	/**
	 * Добавление в тему демо-контент
	 * 
	 * @return void
	 */
	public function generate_demo()
	{
		if(! Custom::name())
		{
			return;
		}
		if(IS_DEMO)
		{
			throw new Exception('В демонстрационном режиме эта функция не доступна.');
		}
		Custom::inc("modules/custom/admin/custom.admin.demo.php");
		$class = new Custom_admin_demo($this->diafan);
		$count = $class->generate();
		if(! $count)
		{
			echo '<div class="error">';
			echo $this->diafan->_('Демо-данные не добавлены. Нет изменений в контенте.');
		}
		else
		{
			echo '<div class="ok">';
			echo $this->diafan->_('Демо-данные добавлены в текущую тему. Сгенерировано файлов: %s.', $count);
		}
		echo '</div>';
	}

	/**
	 * Исполнение SQL-запросов в файле install.sql
	 *
	 * @param string $name название темы
	 * @return void
	 */
	private function install_sql($name)
	{
		if(! file_exists(ABSOLUTE_PATH.'custom/'.$name.'/install.sql'))
			return;

		Custom::inc("modules/service/admin/service.admin.db.php");
		$obj = new Service_admin_db($this->diafan);
		$obj->import_query(ABSOLUTE_PATH.'custom/'.$name.'/install.sql', false);
	}
}