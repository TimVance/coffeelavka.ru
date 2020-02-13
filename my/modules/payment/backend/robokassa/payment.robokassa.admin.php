<?php
/**
 * Настройки платежной системы Robokassa для административного интерфейса
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

class Payment_robokassa_admin
{
	public $config;

	public function __construct()
	{
		$this->config = array(
			"name" => 'Robokassa',
			"params" => array(
                'robokassa_login' => 'Robokassa: логин',
                'robokassa_pass_1' => 'Robokassa: пароль 1',
                'robokassa_pass_2' => 'Robokassa: пароль 2',
				'robokassa_test' => array('name' => 'Тестовый режим', 'type' => 'checkbox'),
			)
		);
	}
}