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

//способы доставки
if (! empty($result["delivery"]))
{
	echo '<div class="table-responsive-new"><table class="cart table delivery-table table-bordered">
	
	<tr class="bgcart2">
	<th colspan="'.($result["discount"] ? 7 : 5).'" class="cart_delivery_title cart_last_th">'.$this->diafan->_('Способ доставки').'</th>
	</tr>';
	foreach ($result["delivery"] as $row)
	{
		if(! empty($result["hide_form"]) && $row["id"] != $result["cart_delivery"])
			continue;

		if (! empty($row["thresholds"]) && empty($result["hide_form"]))
		{
			foreach ($row["thresholds"]  as $r)
			{
			if($r["amount"])
			{
				$row['text'] .= '<div>'.($r["price"] ? $this->diafan->_('Стоимость').' '.$r["price"].' '.$result["currency"].' '.$this->diafan->_('от суммы') : $this->diafan->_('Бесплатно от суммы')).' '.$r['amount'].' '.$result["currency"] . '</div>';
			}
			else
			{
				$row['text'] .= '<div>'.($r["price"] ? $this->diafan->_('Стоимость').' '.$r["price"].' '.$result["currency"] : $this->diafan->_('Бесплатно')) . '</div>';
			}
			}
		}
		echo '
		<tr class="js_check_delivery '.($row["id"] == $result["cart_delivery"] ? ' delivery_active' : '').'">
			<td colspan="'.($result["discount"] ? 6 : 4).'" class="cart_delivery">
				<div class="cart_delivery_name">'.$row["name"].($row["id"] == 6 ? $this->htmleditor('<insert name="show_block" id="13" module="site">') : '').'</div>
				'.(empty($result["hide_form"]) ? '<div class="delivery_text_wrapper"><span class="show_detail js_open_delivery_modal" data-id="delivery_modal_'.$row['id'].'">Подробнее</span><div id="delivery_modal_'.$row['id'].'" class="cart_delivery_text">'.$row['text'].'</div></div>' : '').'
			</td>
			<td class="cart_summ">'.$row["price"].'
			'.(empty($result["hide_form"]) ? '<input name="delivery_id" id="delivery_id_'.$row['id'].'" value="'.$row['id'].'" class="js_cart_delivery" type="radio" form="cart-table-form" '.($row["id"] == $result["cart_delivery"] ? ' checked' : '').'>' : '').'
			</td>
		</tr>';
	}
	echo '</table></div>';
}