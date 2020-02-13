<?php
/**
 * Установка модуля
 *
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined("DIAFAN"))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

class Payment_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"payment" => array(
			array(
				"id" => 1,
				"name" => array("Наличными курьеру"),
				"text" => array("Заказ необходимо оплатить курьеру на руки наличными"),
				"sort" => 1,
			),
			array(
				"id" => 3,
				"name" => array("Электронные деньги"),
				"payment" => "yandexmoney",
				"params" => "a:3:{s:11:\"yandex_scid\";s:7:\"9850771\";s:13:\"yandex_shopid\";s:5:\"58469\";s:12:\"yandex_types\";a:10:{s:2:\"PC\";s:25:\"Яндекс.Деньги\";s:2:\"AC\";s:31:\"Банковская карта\";s:2:\"MC\";s:33:\"Мобильный телефон\";s:2:\"GP\";s:18:\"Терминалы\";s:2:\"WM\";s:8:\"WebMoney\";s:2:\"SB\";s:29:\"Сбербанк Онлайн\";s:2:\"MP\";s:42:\"Мобильный терминал (mPOS)\";s:2:\"AB\";s:19:\"Альфа-Клик\";s:4:\"МА\";s:34:\"Оплата через MasterPass\";s:2:\"PB\";s:50:\"Оплата через Промсвязьбанк\";}}",
				"sort" => 6,
			),
			array(
				"id" => 4,
				"name" => array("на Яндекс деньги"),
				"text" => array("оплатите <a href=\"http://www.coffeelavka.ru/oplata/\" target=\"_blank\">здесь</a>"),
				"params" => "a:0:{}",
				"sort" => 4,
			),
			array(
				"id" => 5,
				"name" => array("Банковский платеж (для юр. лиц)"),
				"text" => array("Мы пришлем счет вам на почту"),
				"payment" => "non_cash",
				"params" => "a:0:{}",
				"sort" => 5,
			),
			array(
				"id" => 6,
				"name" => array("Оплата картой при получении заказа"),
				"text" => array("У курьера будет с собой терминал"),
				"sort" => 3,
			),
		),
	);
}