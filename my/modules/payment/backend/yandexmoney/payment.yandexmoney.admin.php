<?php
/**
 * Настройки платежной системы Яндекс.Касса для административного интерфейса
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

class Payment_yandexmoney_admin
{
	public $config;
	private $diafan;

	public function __construct(&$diafan)
	{
		$this->diafan = &$diafan;
		$this->config = array(
			"name" => 'Яндекс.Касса',
			"params" => array(
				'yandex_scid' => 'sсId',
				'yandex_shopid' => 'shopId',
				'yandex_password' => 'shopPassword',
				'yandex_test' => array('name' => 'Тестовый режим', 'type' => 'checkbox'),
				'yandex_types' => array('name' => 'Способы оплаты', 'type' => 'function')
			)
		);
	}
	
	/**
	 * Редактирвание поля "Способы оплаты"
	 *
	 * @return void
	 */
	public function edit_variable_yandex_types($value)
	{
		if($value)
		{
			$vs = array_keys($value);
		}
		else
		{
			$vs = array();
		}
		$types = array(
		    'PC' => 'Яндекс.Деньги',
			'AC' => 'Банковская карта',
			'MC' => 'Мобильный телефон',
			'GP' => 'Терминалы',
			'WM' => 'WebMoney',
			'SB' => 'Сбербанк Онлайн',
			'MP' => 'Мобильный терминал (mPOS)',
			'AB' => 'Альфа-Клик',
			'МА' => 'Оплата через MasterPass',
			'PB' => 'Оплата через Промсвязьбанк',
			'QW' => 'Оплата через QIWI Wallet',
		);
		echo '<div class="unit tr_payment" payment="yandexmoney" style="display:none">
			<div class="infofield">'.$this->diafan->_('Способы оплаты').'</div>';
			foreach($types as $k => $v)
			{
				echo '<input type="checkbox" name="yandex_types['.$k.']" id="input_yandex_types_'.$k.'" value="'.$v.'"'.(in_array($k, $vs) ? ' checked' : '').' class="label_full"> <label for="input_yandex_types_'.$k.'">'.$this->diafan->_($v).'</label>';
			}
			echo '
		</div>';
	}
	
	/**
	 * Сохранение поля "Способы оплаты"
	 *
	 * @return string
	 */
	public function save_variable_yandex_types()
	{
		if(empty($_POST["yandex_types"]))
		{
			$_POST["yandex_types"] = array();
		}
		return $_POST["yandex_types"];
	}
}