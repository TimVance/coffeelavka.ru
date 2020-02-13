<?php
/**
 * Комментарии для событий
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
 * Comments_admin_dashboard
 */
class Comments_admin_dashboard extends Diafan
{
	/**
	 * @var string название таблицы
	 */
	public $name = 'Комментарии';

	/**
	 * @var integer порядковый номер для сортировки
	 */
	public $sort = 3;

	/**
	 * @var string таблица в базе данных
	 */
	public $table = 'comments';

	/**
	 * @var string нет элементов
	 */
	public $empty_rows = 'Нет новых комментариев.';

	/**
	 * @var string условие для отбора
	 */
	public $where = "act='0'";

	/**
	 * @var array поля в таблице
	 */
	public $variables = array (
		'created' => array(
			'name' => 'Дата и время',
			'type' => 'datetime',
			'sql' => true,
		),
		'text' => array(
			'name' => 'Комментарий',
			'type' => 'text',
			'sql' => true,
			'link' => true,
		),
	);
}