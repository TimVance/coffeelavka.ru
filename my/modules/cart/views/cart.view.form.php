<?php
/**
 * Шаблон формы редактирования корзины товаров, оформления заказа
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

if (empty($result["rows"]))
{
	echo '<p>'.$this->diafan->_('Корзина пуста.').' <a href="'.BASE_PATH_HREF.$result["shop_link"].'">'.$this->diafan->_('Перейти к покупкам.').'</a></p>';
	return;
}

echo '<a name="top"></a>
<div class="cart_order">';
echo '<div class="cart-accordion">';
echo '
	<div class="bgcart5 acc-block-header"><i class="fa fa-list-alt"></i>Ваш заказ</div>
	<div class="acc-block-content">
<form action="" method="POST" id="cart-table-form" class="js_cart_table_form cart_table_form ajax">
<input type="hidden" name="module" value="cart">
<input type="hidden" name="action" value="recalc">
<input type="hidden" name="form_tag" value="'.$result["form_tag"].'">
<div class="errors errorspos error"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>
<div class="cart_table">';
echo $this->get('table', 'cart', $result); //вывод таблицы с товарами
echo '</div>';
echo '<div class="cart_recalc">';
// кнопка пересчитать
echo '<input type="submit" value="'.$this->diafan->_('Пересчитать', false).'">';
echo '</div>';
echo '</form>';

if (!empty($result["rows"])) {
	echo '
	<div class="step-btn-wrapper">
		<button class="btn btn-warning btn-sm js-next-step" type="button">Далее</button>
	</div>
	';
}
echo '</div>';
if (empty($result["rows"]))
{
	echo '</div></div>';
	return false;
}

// вывод списка доставок
echo '<div class="bgcart5 acc-block-header"><i class="fa fa-location-arrow"></i>Доставка или самовывоз</div>';
echo '<div class="acc-block-content">';
	echo $this->get('delivery', 'cart', $result);
	echo '<div class="step-btn-wrapper">
	<button class="btn btn-warning btn-sm js-prev-step" type="button">Назад</button>
	<button class="btn btn-warning btn-sm js-next-step" type="button">Далее</button>
	</div>';
echo '</div>';

echo '<div class="bgcart5 acc-block-header"><i class="fa fa-user"></i>Ваши данные для связи</div>
<div class="acc-block-content">
<div class="order-form-wrapper">
<div class="row carts">
<form method="POST" action="" id="cart-order-form" class="cart_form ajax " enctype="multipart/form-data">
<input type="hidden" name="module" value="cart">
<input type="hidden" name="action" value="order">
<input type="hidden" name="tmpcode" value="'.md5(mt_rand(0, 9999)).'">
<br>';

if(! empty($result["yandex_fast_order"]))
{
	echo '<p><a href="'.$result["yandex_fast_order_link"].'"><img src="http://cards2.yandex.net/hlp-get/5814/png/3.png" border="0" /></a></p>';
}

$required = false;
if (! empty($result["rows_param"]))
{
	foreach ($result["rows_param"] as $row)
	{
		if($row["required"])
		{
			$required = true;
		}
		$value = ! empty($result["user"]['p'.$row["id"]]) ? $result["user"]['p'.$row["id"]] : '';

		echo '<div class="form-group col-md-6  order_form_param'.$row["id"].'">';

		switch ($row["type"])
		{
			case 'title':
				echo '<div class="infoform">'.$row["name"].':</div>';
				break;

			case 'text':
				echo '<label>'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<input type="text" class="form-control inp'.$row["id"].'" name="p'.$row["id"].'"  value="'.str_replace('"', '&quot;', $value).'" placeholder="'.($row["required"] ? '' : 'заполняйте по желанию').'">';
				break;

			case "email":
				echo '<label>'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<input type="email" class="form-control" name="p'.$row["id"].'" value="'.str_replace('"', '&quot;', $value).'" placeholder="'.($row["required"] ? '' : 'заполняйте по желанию').'">';
				break;

			case "phone":
				echo '<label>'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<input type="tel" class="form-control" name="p'.$row["id"].'" value="'.$value.'" placeholder="'.($row["required"] ? '' : 'заполняйте по желанию').'">';
				break;

			case 'textarea':
				echo '<label>'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<textarea class="form-control" rows="5" name="p'.$row["id"].'" placeholder="'.($row["required"] ? '' : 'заполняйте по желанию').'">'.str_replace(array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), $value).'</textarea>';
				break;

			case 'date':
			case 'datetime':
				$timecalendar  = true;
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
					<input type="text" name="p'.$row["id"].'" value="'.$value.'" class="timecalendar" showTime="'
					.($row["type"] == 'datetime'? 'true' : 'false').'">';
				break;

			case 'numtext':
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<input type="number" name="p'.$row["id"].'" size="5" value="'.$value.'">';
				break;

			case 'checkbox':
				echo '<input name="p'.$row["id"].'" id="cart_p'.$row["id"].'" value="1" type="checkbox" '.($value ? ' checked' : '').'><label for="cart_p'.$row["id"].'">
				<span style="color:red;">*</span> Даю согласие на обработку моих персональных данных. Соглашаюсь с  <a style="color:#f6c700;" href="/privacy-policy/" target="_blank">политикой конфиденциальности</a> и ознакомлен с <a style="color:#f6c700;" href="/privacy-policy/" target="_blank">политикой в отношении обработки персональных данных</a>
				</label>';
				break;

			case 'select':
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<select name="p'.$row["id"].'" class="inpselect">
					<option value="">-</option>';
				foreach ($row["select_array"] as $select)
				{
					echo '<option value="'.$select["id"].'"'.($value == $select["id"] ? ' selected' : '').'>'.$select["name"].'</option>';
				}
				echo '</select>';
				break;

			case 'multiple':
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>';
				foreach ($row["select_array"] as $select)
				{
					echo '<input name="p'.$row["id"].'[]" id="cart_p'.$select["id"].'[]" value="'.$select["id"].'" type="checkbox" '.(is_array($value) && in_array($select["id"], $value) ? ' checked' : '').'><label for="cart_p'.$select["id"].'[]">'.$select["name"].'</label><br>';
				}
				break;

			case "attachments":
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>';
				echo '<div class="inpattachment"><input type="file" name="attachments'.$row["id"].'[]" class="inpfiles" max="'.$row["max_count_attachments"].'"></div>';
				echo '<div class="inpattachment" style="display:none"><input type="file" name="hide_attachments'.$row["id"].'[]" class="inpfiles" max="'.$row["max_count_attachments"].'"></div>';
				if ($row["attachment_extensions"])
				{
					echo '<div class="attachment_extensions">('.$this->diafan->_('Доступные типы файлов').': '.$row["attachment_extensions"].')</div>';
				}
				break;

			case "images":
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div><div class="images"></div>';
				echo '<input type="file" name="images'.$row["id"].'" param_id="'.$row["id"].'" class="inpimages">';
				break;
		}

		echo '<div class="order_form_param_text">'.$row["text"].'</div>

		<small class="errors error_p'.$row["id"].'"'.($result["error_p".$row["id"]] ? '>'.$result["error_p".$row["id"]] : ' style="display:none">').'</small></div>';
	}
	if(! empty($result["subscribe_in_order"]))
	{
		echo '<input type="checkbox" checked name="subscribe_in_order" id="subscribe_in_order"><label for="subscribe_in_order">'.$this->diafan->_('Подписаться на новости').'</label>';
	}

if($required)
{
	echo '<div class="required_field"><span style="color:red;">*</span> — '.$this->diafan->_('Поля, обязательные для заполнения').'</div>';
}
}

echo '</div></div>
	<div class="step-btn-wrapper">
		<button class="btn btn-warning btn-sm js-prev-step" type="button">Назад</button>
		<button class="btn btn-warning btn-sm js-next-step" type="button">Далее</button>
	</div>
</div>';

if(! empty($result["payments"]))
{
	foreach($result["payments"] as $payKey=>$payRow) {
		$result["payments"][$payKey]['form'] = "cart-order-form";
	}
	echo '
	<div class="bgcart5 acc-block-header"><i class="fa fa-credit-card"></i>Способ оплаты</div>
	<div class="acc-block-content">'
		. $this->get('list', 'payment', $result["payments"]) .
		'<div class="step-btn-wrapper">
			<button class="btn btn-warning btn-sm js-prev-step" type="button">Назад</button>
			<button class="btn btn-warning btn-sm js-next-step" type="button">Далее</button>
		</div>
	</div>';
}

// вывод итоговой стоимости
echo'
	<div class="bgcart5 acc-block-header"><i class="fa fa-info-circle"></i>Итого</div>
	<div class="acc-block-content">
		<div class="cart_summary">';
			echo $this->get('total', 'cart', $result);
echo '
		</div>
		<div class="step-btn-wrapper">
			<button class="btn btn-warning btn-sm js-prev-step" type="button">Назад</button>
			<input class="btn btn-warning btn-sm" form="cart-order-form" type="submit" value="'.$this->diafan->_('Подтвердить заказ', false).'" >
		</div>
	</div>';

echo '</div>';

echo '<div class=" errors error"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>';

echo '</form><br><br><br>';

// if($result["show_auth"])
// {
// 	echo '<div class="cart_autorization">';
// 	echo $this->diafan->_('Если Вы оформляли заказ на сайте ранее, просто введите логин и пароль:');
// 	echo '<br>';
// 	echo $this->get('show_login', 'registration', $result["show_login"]);
// 	echo '</div>';

// 	echo '<div class="cart_registration">';
// 	echo $this->diafan->_('Если Вы заполните форму регистрации, то при заказе в следующий раз Вам не придется повторно заполнять Ваши данные:');
// 	echo $this->get('form', 'registration', $result["registration"]);
// 	echo '</div>';
// }
echo '</div>';
