<?php
/**
 * Список описанных файлов
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
 * Shop_admin_importexport_category
 */
class Shop_admin_importexport_category extends Frame_admin
{
	/**
	 * @var string таблица в базе данных
	 */
	public $table = 'shop_import_category';

	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'main' => array (
			'name' => array(
				'type' => 'text',
				'name' => 'Название',
				'help' => 'Краткое описание файла импорта (например, «Импорт товаров», «Импорт цен» и т. д.).',
			),
			'type' => array(
				'type' => 'select',
				'name' => 'Тип',
				'select' => array(
					'good' => 'Товары',
					'category' => 'Категории',
					'brand' => 'Производители',
				),
			),
			'delete_items' => array(
				'type' => 'checkbox',
				'name' => 'Удалять неописанные в файле импорта записи',
				'help' => 'Если список товаров или категорий в файле является исчерпывающим, то следует отметить эту опцию. Тогда при импорте удалятся ранее занесенные товары или категории, кроме тех, что будут обновлены (определяется по идентификатору).',
			),
			'site_id' => array(
				'type' => 'function',
				'name' => 'Раздел сайта',
				'help' => 'Страница сайта с прикрепленным модулем «Магазин», для которой будет производится импорт.',
			),
			'cat_id' => array(
				'type' => 'function',
				'name' => 'Категория товаров',
				'help' => 'Возможность ограничить импорт/экспорт одной категорией магазина.',
			),
			'count_part' => array(
				'type' => 'numtext',
				'name' => 'Количество строк, выгружаемых за один проход скрипта',
				'help' => 'Время работы скрипта ограничено, из-за чего скрипт может не успеть обработать весь файл за одну итерацию. Поэтому файл обрабатывается частями, величину итерации можно задать этим параметром.',
				'default' => 200
			),
			'delimiter' => array(
				'type' => 'text',
				'name' => 'Разделитель данных в строке',
				'help' => 'Разделитель полей в строке.',
				'default' => ";"
			),
			'end_string' => array(
				'type' => 'text',
				'name' => 'Обозначать конец строки символом',
				'help' => 'Если в строке содержатся символы перевода строки (например, в описании товара), то конец строки должен быть обозначен отдельным символом. Например, КОНЕЦ_СТРОКИ. Не обязательный параметр.'
			),
			'encoding' => array(
				'type' => 'text',
				'name' => 'Кодировка',
				'help' => 'Кодировка данных в файле CSV. Обычно cp1251 или utf8.',
				'default' => 'cp1251',
			),
			'sub_delimiter' => array(
				'type' => 'text',
				'name' => 'Разделитель данных внутри поля',
				'help' => 'Некоторые поля содержат несколько данных в одной ячейки (например, значение характеристики с типом «список с выбором нескольких значений» или изображения), в этом случае данные разделены этим разделителем.',
				'default' => '|',
			),
			'sort' => array(
				'type' => 'function',
				'name' => 'Сортировка: установить перед',
				'help' => 'Редактирование порядка следования категории в списке. Поле доступно для редактирования только для категорий, отображаемых на сайте.',
			),
		),
	);

	/**
	 * @var array поля в списка элементов
	 */
	public $variables_list = array (
		'checkbox' => '',
		'sort' => array(
			'name' => 'Сортировка',
			'type' => 'numtext',
			'sql' => true,
			'fast_edit' => true,
		),
		'name' => array(
			'name' => 'Название'
		),
		'actions' => array(
			'trash' => true,
		),
	);

	/**
	 * @var array настройки модуля
	 */
	public $config = array (
		'category', // часть модуля - категории
		'link_to_element', // основная ссылка ведет к списку элементов, принадлежащих категории
	);

	/**
	 * Выводит ссылку на добавление
	 * @return void
	 */
	public function show_add()
	{
		$this->diafan->addnew_init('Добавить описание файла импорта/экспорта');
	}

	/**
	 * Выводит список категорий
	 * @return void
	 */
	public function show()
	{
		$this->diafan->list_row();
	}

	/**
	 * Редактирование поля "Категория"
	 * 
	 * @return void
	 */
	public function edit_variable_cat_id()
	{
		if(! $this->diafan->configmodules("cat", "shop"))
		{
			return;
		}

		$rows = DB::query_fetch_all("SELECT id, [name], parent_id, site_id AS rel FROM {shop_category} WHERE trash='0' ORDER BY sort ASC LIMIT 1000");
		if(count($rows) == 1000)
		{
			return;
		}
		foreach ($rows as $row)
		{
			$cats[$row["parent_id"]][] = $row;
		}
		echo '
		<div class="unit" id="cat_id">
			<div class="infofield">'.$this->diafan->variable_name().$this->diafan->help().'</div>';

		echo ' <select name="cat_id">
		<option value="" rel="0">'.$this->diafan->_('Все').'</option>';
		echo $this->diafan->get_options($cats, $cats[0], array($this->diafan->value));
		echo '</select>';

		echo '</div>';
	}

	/**
	 * Сохранение поля "Категория"
	 *
	 * @return void
	 */
	public function save_variable_cat_id()
	{
		$this->diafan->set_query("cat_id=%d");
		$this->diafan->set_value($_POST["cat_id"]);
	}
}