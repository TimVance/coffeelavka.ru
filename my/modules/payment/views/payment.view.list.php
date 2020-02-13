<?php
/**
 * Шаблон списка платежных система при оплате
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

if(empty($result))
{
	return;
}

echo '<div class="payments">';
foreach ($result as $i => $row)
{
	echo '<div class="payment js_check_payment '.(! $i ? 'payment_active' : '').'">
	<input name="payment_id" '. (!empty($row['form']) ? 'form="'.$row['form'].'"' : '' ).' id="payment'.$row['id'].'" value="'.$row['id'].'" type="radio" '.(! $i ? 'checked' : '').' class="js_cart_payment">
	<label for="payment'.$row['id'].'">'.$row['name'].'</label>';
	if(! empty($row['text']))
	{
		echo '<div class="payment_text">'.$row['text'].'</div>';
	}
	echo '</div>';
}
echo '</div>';
