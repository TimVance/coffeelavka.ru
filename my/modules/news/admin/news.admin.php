<?php
/**
 * Редактирование новостей
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
 * News_admin
 */
class News_admin extends Frame_admin
{
	/**
	 * @var string таблица в базе данных
	 */
	public $table = 'news';

	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'main' => array (
			'name' => array(
				'type' => 'text',
				'name' => 'Название новости',
				'help' => 'Используется в ссылках на новость, заголовках.',
				'multilang' => true,
			),
			'created' => array(
				'type' => 'datetime',
				'name' => 'Дата',
				'help' => 'Вводится в формате дд.мм.гггг чч:мм. Если указать будущую дату, новость начнет отображаться с этой даты.',
			),
			'act' => array(
				'type' => 'checkbox',
				'name' => 'Опубликовать на сайте',
				'help' => 'Если не отмечена, новость не увидят посетители сайта.',
				'default' => true,
				'multilang' => true,
			),
			'prior' => array(
				'type' => 'checkbox',
				'name' => 'Важно (всегда сверху)',
				'help' => 'Если отмечена, новость выведется в начале списка, независимо от сортировки по дате. Если важных новостей несколько, между собой они будут сортироваться по дате.',
			),
			'cat_id' => array(
				'type' => 'function',
				'name' => 'Категория',
				'help' => 'Категория, к которой относится новость. Список категорий редактируется во вкладке выше. Возможно выбрать дополнительные категории, в которых новость также будет выводится. Чтобы выбрать несколько категорий, удерживайте CTRL. Параметр выводится, если в настройках модуля отмечена опция «Использовать категории».',
			),
			'images' => array(
				'type' => 'module',
				'name' => 'Изображения',
				'help' => 'Изображения будут загружены автоматически после выбора. После загрузки изображения будут обработаны автоматически, согласно настройкам модуля. Параметр выводится, если в настройках модуля отмечена опция «Использовать изображения».',
			),
			'anons' => array(
				'type' => 'editor',
				'name' => 'Анонс',
				'help' => 'Краткое начало новости. Выводится в списках новостей и в блоках. Если отметить «Добавлять к описанию», на странице элемента анонс выведется вместе с основным описанием. Иначе анонс выведется только в списке, а на отдельной странице будет только описание. Если отметить «Применить типограф», контент будет отформатирован согласно правилам экранной типографики с помощью [веб-сервиса «Типограф»](http://www.artlebedev.ru/tools/typograf/webservice/). Опция «HTML-код» позволяет отключить визуальный редактор для текущего поля. Значение этой настройки будет учитываться и при последующем редактировании.',
				'multilang' => true,
				'height' => 200,
			),
			'text' => array(
				'type' => 'editor',
				'name' => 'Основной контент новости',
				'help' => 'Полный текст для страницы новости. Если отметить «Применить типограф», контент будет отформатирован согласно правилам экранной типографики с помощью [веб-сервиса «Типограф»](http://www.artlebedev.ru/tools/typograf/webservice/). Опция «HTML-код» позволяет отключить визуальный редактор для текущего поля. Значение этой настройки будет учитываться и при последующем редактировании.',
				'multilang' => true,
			),
			'hr1' => 'hr',
			'dynamic' => array(
				'type' => 'function',
				'name' => 'Динамические блоки',
			),			
			'tags' => array(
				'type' => 'module',
				'name' => 'Теги',
				'help' => 'Добавление тегов к новости. Можно добавить либо новый тег, либо открыть и выбрать из уже существующих тегов. Параметр выводится, если в настройках модуля включен параметр «Подключить теги».',
			),			
			'rel_elements' => array(
				'type' => 'function',
				'name' => 'Похожие новости',
				'help' => 'Выбор и добавление к текущей новости связей с другими новостями. Похожие новости выводятся шаблонным тегом show_block_rel. По умолчанию связи между новостями являются односторонними, это можно изменить, отметив опцию «В блоке похожих новостей связь двусторонняя» в настройках модуля.',
			),	
			'hr2' => 'hr',
			'counter_view' => array(
				'type' => 'function',
				'name' => 'Счетчик просмотров',
				'help' => 'Количество просмотров на сайте текущей новости. Статистика ведется и параметр выводится, если в настройках модуля отмечена опция «Подключить счетчик просмотров».',
				'no_save' => true,
			),
			'rating' => array(
				'type' => 'module',
				'name' => 'Рейтинг',
				'help' => 'Средний рейтинг, согласно голосованию пользователей сайта. Параметр выводится, если в настройках модуля включен параметр «Подключить рейтинг к новостям».',
			),			
			'comments' => array(
				'type' => 'module',
				'name' => 'Комментарии',
				'help' => 'Комментарии, которые оставили пользователи к текущей новости. Параметр выводится, если в настройках модуля включен параметр «Показывать комментарии к новостям».',
			),			
		),
		'other_rows' => array (	
			'number' => array(
				'type' => 'function',
				'name' => 'Номер',
				'help' => 'Номер элемента в БД (веб-мастеру и программисту).',
				'no_save' => true,
			),
			'admin_id' => array(
				'type' => 'function',
				'name' => 'Редактор',
				'help' => 'Изменяется после первого сохранения. Показывает, кто из администраторов сайта первый правил текущую страницу.'
			),
			'timeedit' => array(
				'type' => 'text',
				'name' => 'Время последнего изменения',
				'help' => 'Изменяется после сохранения элемента. Отдается в заголовке *Last Modify*.',
			),
			'site_id' => array(
				'type' => 'function',
				'name' => 'Раздел сайта',
				'help' => 'Перенос новости на другую страницу сайта, к которой прикреплен модуль новостей. Параметр выводится, если в настройках модуля отключена опция «Использовать категории», если опция подключена, то раздел сайта задается такой же, как у основной категории.',
			),			
			'title_seo' => array(
				'type' => 'title',
				'name' => 'Параметры SEO',
			),
			'title_meta' => array(
				'type' => 'text',
				'name' => 'Заголовок окна в браузере, тег Title',
				'help' => 'Если не заполнен, тег *Title* будет автоматически сформирован как «Названия новости – Название страницы – Название сайта», либо согласно шаблонам автоформирования из настроек модуля (SEO-специалисту).',
				'multilang' => true,
			),
			'keywords' => array(
				'type' => 'textarea',
				'name' => 'Ключевые слова, тег Keywords',
				'help' => 'Если не заполнен, тег *Keywords* будет автоматически сформирован согласно шаблонам автоформирования из настроек модуля (SEO-специалисту).',
				'multilang' => true,
			),
			'descr' => array(
				'type' => 'textarea',
				'name' => 'Описание, тег Description',
				'help' => 'Если не заполнен, тег *Description* будет автоматически сформирован согласно шаблонам автоформирования из настроек модуля (SEO-специалисту).',
				'multilang' => true,
			),
			'canonical' => array(
				'type' => 'text',
				'name' => 'Канонический тег',
				'multilang' => true,
			),
			'rewrite' => array(
				'type' => 'function',
				'name' => 'Псевдоссылка (ЧПУ)',
				'help' => 'ЧПУ, т.е. адрес страницы вида: *http://site.ru/psewdossylka/*. Смотрите параметры сайта (SEO-специалисту).',
			),
			'redirect' => array(
				'type' => 'none',
				'name' => 'Редирект на текущую страницу со страницы',
				'help' => 'Позволяет делать редирект с указанной страницы на текущую.',
				'no_save' => true,
			),
			'changefreq'   => array(
				'type' => 'function',
				'name' => 'Changefreq',
				'help' => 'Вероятная частота изменения этой страницы. Это значение используется для генерирования файла sitemap.xml. Подробнее читайте в описании [XML-формата файла Sitemap](http://www.sitemaps.org/ru/protocol.html) (SEO-специалисту).',
			),
			'priority'   => array(
				'type' => 'floattext',
				'name' => 'Priority',
				'help' => 'Приоритетность URL относительно других URL на Вашем сайте. Это значение используется для генерирования файла sitemap.xml. Подробнее читайте в описании [XML-формата файла Sitemap](http://www.sitemaps.org/ru/protocol.html) (SEO-специалисту).',
			),
			'title_show' => array(
				'type' => 'title',
				'name' => 'Параметры показа',
			),
			'map_no_show' => array(
				'type' => 'checkbox',
				'name' => 'Не показывать на карте сайта',
				'help' => 'Скрывает отображение ссылки на новость в файле sitemap.xml и [модуле «Карта сайта»](http://www.diafan.ru/dokument/full-manual/modules/map/).',
			),
			'access' => array(
				'type' => 'function',
				'name' => 'Доступ к новости',
				'help' => 'Если отметить опцию «Доступ только», новость увидят только авторизованные на сайте пользователи, отмеченных типов. Не авторизованные, в том числе поисковые роботы, увидят «404 Страница не найдена» (администратору сайта).',
			),
			'date_period' => array(
				'type' => 'date',
				'name' => 'Период показа',
				'help' => 'Если заполнить, текущая новость будет опубликована на сайте в указанный период. В иное время пользователи сайта новость не будут видеть, получая ошибку 404 «Страница не найдена» (администратору сайта).'
			),
			'title_view' => array(
				'type' => 'title',
				'name' => 'Шаблоны',
			),
			'theme' => array(
				'type' => 'function',
				'name' => 'Шаблон страницы',
				'help' => 'Возможность подключить для страницы новости шаблон сайта отличный от основного (themes/site.php). Все шаблоны для сайта должны храниться в папке *themes* с расширением *.php* (например, themes/dizain_so_slajdom.php). Подробнее в [разделе «Шаблоны сайта»](http://www.diafan.ru/dokument/full-manual/templates/site/). (веб-мастеру и программисту, не меняйте этот параметр, если не уверены в результате!).',
			),
			'view' => array(
				'type' => 'function',
				'name' => 'Шаблон модуля',
				'help' => 'Шаблон вывода контента модуля на странице отдельной новости (веб-мастеру и программисту, не меняйте этот параметр, если не уверены в результате!).',
			),
			'search' => array(
				'type' => 'module',
				'name' => 'Индексирование для поиска',
				'help' => 'Новость автоматически индексируется для модуля «Поиск по сайту» при внесении изменений.',
			),
			'map' => array(
				'type' => 'module',
				'name' => 'Индексирование для карты сайта',
				'help' => 'Новость автоматически индексируется для карты сайта sitemap.xml.',
			),
		),
	);

	/**
	 * @var array поля в списка элементов
	 */
	public $variables_list = array (
		'checkbox' => '',
		'name' => array(
			'name' => 'Название и категория',
			'sql' => true,
		),
		'adapt' => array(
			'class_th' => 'item__th_adapt',
		),
		'separator' => array(
			'class_th' => 'item__th_seporator',
		),
		'created' => array(
			'name' => 'Дата и время',
			'type' => 'datetime',
			'sql' => true,
			'no_important' => true,
		),
		'anons' => array(
			'name' => 'Анонс',
			'sql' => true,
			'type' => 'text',
			'class' => 'text',
			'no_important' => true,
		),
		'text' => array(
			'name' => 'Описание',
			'sql' => true,
			'type' => 'text',
			'class' => 'text',
			'no_important' => true,
		),
		'actions' => array(
			'view' => true,
			'act' => true,
			'trash' => true,
		),
	);

	/**
	 * @var array поля для фильтра
	 */
	public $variables_filter = array (
		'no_cat' => array(
			'type' => 'checkbox',
			'name' => 'Нет категории',
		),
		'no_img' => array(
			'type' => 'checkbox',
			'name' => 'Нет картинки',
		),
		'hr2' => array(
			'type' => 'hr',
		),
		'cat_id' => array(
			'type' => 'select',
			'name' => 'Искать по категории',
		),
		'site_id' => array(
			'type' => 'select',
			'name' => 'Искать по разделу',
		),
		'name' => array(
			'type' => 'text',
			'name' => 'Искать по названию',
		),
	);

	/**
	 * @var array настройки модуля
	 */
	public $config = array (
		'element_site', // делит элементы по разделам (страницы сайта, к которым прикреплен модуль)
		'element', // используются группы
		'element_multiple', // модуль может быть прикреплен к нескольким группам
	);

	/**
	 * Подготавливает конфигурацию модуля
	 * @return void
	 */
	public function prepare_config()
	{
		if(! $this->diafan->configmodules("cat", "news", $this->diafan->_route->site))
		{
			$this->diafan->config("element", false);
			$this->diafan->config("element_multiple", false);
		}
	}

	/**
	 * Выводит ссылку на добавление
	 * @return void
	 */
	public function show_add()
	{
		if ($this->diafan->config('element') && !$this->diafan->not_empty_categories)
		{
			echo '<div class="error">'.sprintf($this->diafan->_('В %sнастройках%s модуля подключены категории, чтобы начать добавлять новость создайте хотя бы одну %sкатегорию%s.'), '<a href="'.BASE_PATH_HREF.'news/config/">', '</a>','<a href="'.BASE_PATH_HREF.'news/category/'.($this->diafan->_route->site ? 'site'.$this->diafan->_route->site.'/' : '').'">', '</a>').'</div>';
		}
		else
		{
			$this->diafan->addnew_init('Добавить новость');
		}
	}

	/**
	 * Выводит список новостей
	 * @return void
	 */
	public function show()
	{
		$this->diafan->list_row();
	}

	/**
	 * Сопутствующие действия при удалении элемента модуля
	 * @return void
	 */
	public function delete($del_ids)
	{
		$this->diafan->del_or_trash_where("news_rel", "element_id IN (".implode(",", $del_ids).") OR rel_element_id IN (".implode(",", $del_ids).")");
		$this->diafan->del_or_trash_where("news_counter", "element_id IN (".implode(",", $del_ids).")");
	}
}