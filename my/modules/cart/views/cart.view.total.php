<?php
/**
 * Шаблон таблицы с товарами в корзине
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN')) {
    $path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}
if (is_array($result['delivery'])) {
	$deliveryInfo = array_reduce($result['delivery'], function($current, $item) use($result) {
		if ($item['id'] == $result['cart_delivery']) {
			$current = $item;
		}
		return $current;
	}, false);
} else {
	$deliveryInfo = false;
}

echo '
<div class="table-responsive-new">
	<table class="cart table table-bordered">
		<tr>
			<td class="cart_total">'.$this->diafan->_('Сумма').'</td>';
			if($result["discount"]) {
				echo '<td class="cart_old_price"></td>';
				echo '<td class="cart_discount"></td>';
			}
	echo '
			<td class="cart_summ">';
				if(! empty($result["discount_total"])) {
					echo '<div class="cart_summ_old_total">'.$result["old_summ_goods"].'</div>';
				}
	echo 		'<b>' . $result["summ_goods"] . ' '.$result['currency'].'</b>';
	echo '
			</td>
		</tr>';
	if (!empty($deliveryInfo) && !empty($deliveryInfo["price"])) {
	echo '
		<tr class="cart_last_tr">
			<td class="cart_total">'.$this->diafan->_('Доставка').'</td>';
			if($result["discount"]) {
				echo '<td class="cart_old_price"></td>';
				echo '<td class="cart_discount"></td>';
			}
			echo '<td class="cart_summ"><b>'.$deliveryInfo["price"].' '.$result['currency'].'</b></td>
		</tr>';
	}
	echo '
		<tr class="cart_last_tr">
			<td class="cart_total">'.$this->diafan->_('Итого').'</td>';
			if($result["discount"]) {
				echo '<td class="cart_old_price"></td>';
				echo '<td class="cart_discount"></td>';
			}
			echo '<td class="cart_summ"><b>'.$result["summ"].' '.$result['currency'].'</b></td>
		</tr>
	</table>
</div>';