<?php
/**
 * Настройки модуля
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
 * Tags_admin_config
 */
class Tags_admin_config extends Frame_admin
{
	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'config' => array (
			'nastr' => array(
				'type' => 'numtext',
				'name' => 'Количество элементов на странице',
				'help' => 'Количество одновременно выводимых новостей, товаров, фотографий и др., помеченных тегом в списке.',
			),
			'images' => array(
				'type' => 'module',
				'element_type' => array('element'),
				'hide' => true,
			),
			'images_element' => array(
				'type' => 'none',
				'name' => 'Использовать изображения',
				'help' => 'Если отмечена, к тегам можно будет будет добавлять изображения.',
				'no_save' => true,
			),
			'images_variations_element' => array(
				'type' => 'none',
				'name' => 'Генерировать размеры изображений',
				'help' => 'Размеры изображений, заданные в модуле «Изображения».',
				'no_save' => true,
			),
			'list_img_element' => array(
				'type' => 'none',
				'name' => 'Отображение изображений в списке',
				'help' => "Параметр принимает значения:\n\n* нет (отключает отображение изображений в списке);\n* показывать одно изображение;\n* показывать все изображения. Параметр выводится, если отмечена опция «Использовать изображения».",
				'no_save' => true,
			),
			'use_animation' => array(
				'type' => 'none',
				'name' => 'Использовать анимацию при увеличении изображений',
				'help' => 'Параметр добавляет JavaScript код, позволяющий включить анимацию при увеличении изображений. Параметр выводится, если отмечена опция «Использовать изображения».',
				'no_save' => true,
			),
			'upload_max_filesize' => array(
				'type' => 'none',
				'name' => 'Максимальный размер загружаемых файлов',
				'help' => 'Параметр показывает максимально допустимый размер загружаемых файлов, установленный в настройках хостинга. Параметр выводится, если отмечена опция «Использовать изображения».',
				'no_save' => true,
			),
			'resize' => array(
				'type' => 'none',
				'name' => 'Применить настройки ко всем ранее загруженным изображениям',
				'help' => 'Позволяет переконвертировать размер уже загруженных изображений. Кнопка необходима, если изменены настройки размеров изображений. Параметр выводится, если отмечена опция «Использовать изображения».',
				'no_save' => true,
			),
		),
	);

	/**
	 * @var array настройки модуля
	 */
	public $config = array (
		'config', // файл настроек модуля
	);
}