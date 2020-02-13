<?php
/**
 * Шаблон безналичного платежа
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

echo $result["text"]
.'<p><a href="'.BASE_PATH.'payment/get/non_cash/ul/'.$result["id"].'/'.$result["code"].'/">'.$this->diafan->_('Счет для юридических лиц', false).'</a></p>
<p><a href="'.BASE_PATH.'payment/get/non_cash/fl/'.$result["id"].'/'.$result["code"].'/">'.$this->diafan->_('Квитанция для физических лиц', false).'</a></p>';