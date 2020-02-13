<?php
/**
 * Установка модуля
 *
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://cms.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2014 OOO «Диафан» (http://diafan.ru)
 */

if (! defined('DIAFAN'))
{
    include dirname(dirname(dirname(__FILE__))).'/includes/404.php';
}

class Example_install extends Install
{
    /**
     * @var string название
     */
    public $title = "Название модуля";

    /**
     * @var array таблицы в базе данных
     */
    public $tables = array(
		array(
			"name" => "example",
			"fields" => array(
				array(
					"name" => "id",
					"type" => "INT(11) UNSIGNED NOT NULL AUTO_INCREMENT",
				),
				array(
					"name" => "user_id",
					"type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
				),
				array(
					"name" => "created",
					"type" => "INT(10) UNSIGNED NOT NULL DEFAULT '0'",
				),
				array(
					"name" => "text",
					"type" => "text NOT NULL DEFAULT ''",
				),
				array(
					"name" => "sort",
					"type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
				),
				array(
					"name" => "act",
					"type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
				),
				array(
					"name" => "trash",
					"type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
				),
			),
			"keys" => array(
				"PRIMARY KEY (id)",
			),
		),
	);

    /**
     * @var array записи в таблице {modules}
     */
    public $modules = array(
        array(
            "name" => "example",
            "admin" => true,
            "site" => true,
            "site_page" => true,
        ),
    );

    /**
     * @var array меню административной части
     */
    public $admin = array(
        array(
            "name" => "Название модуля",
            "rewrite" => "example",
            "group_id" => "1",
            "sort" => 5,
            "act" => true,
            "children" => array(
                array(
                    "name" => "Настройки",
                    "rewrite" => "example/config",
                ),
            )
        ),
    );
}