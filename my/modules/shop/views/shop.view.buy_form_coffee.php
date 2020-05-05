<?php
/**
 * Шаблон кнопки «Купить», в котором характеристики, влияющие на цену выводятся в виде выпадающего списка
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

if (! empty($result["result"]["access_buy"]))
	return false;

if($result["row"]["empty_price"])
	return false;

$action = '';
if(! $result["result"]["cart_link"] || $result["row"]["no_buy"] || empty($result["row"]["count"]))
{
	$action = 'buy';
}

echo '
<form method="post" action="" class="js_shop_form shop_form ajax">
<input type="hidden" name="good_id" value="'. $result["row"]["id"].'">
<input type="hidden" name="module" value="shop">
<input type="hidden" name="action" value="'.$action.'">';

if ($result["row"]["no_buy"] || empty($result["row"]["count"]))
{
	echo '<div class="js_shop_no_buy js_shop_no_buy_good shop_no_buy shop_no_buy_good text-danger">'.$this->diafan->_('Товар ожидается').'</div>';
	$hide_submit = true;
	$waitlist = true;
}
if(! $result["result"]["cart_link"])
{
    $hide_submit = true;
}

// у товара несколько цен
if ($result["row"]["price_arr"])
{
	foreach ($result["row"]["price_arr"] as $price)
	{
		$param_code = '';
		foreach ($price["param"] as $p)
		{
			if($p["value"])
			{
				$param_code .= ' param'.$p["id"].'="'.$p["value"].'"';
			}
		}
		if(! empty($price["image_rel"]))
		{
			$param_code .= ' image_id="'.$price["image_rel"].'"';
		}
		echo '<div class="js_shop_param_price shop_param_price shop-item-price"'.$param_code.'>';
			echo '<span class="price"><span class="js_shop_price" summ="'.$price["price_no_format"].'">'.$price["price"].'</span> '.$result["result"]["currency"].(!empty($result["row"]["measure_unit"]) ?  ' / '.$result["row"]["measure_unit"] : '');
			if (!empty($price["old_price"]))
			{
				echo '<span class="shop_old_price price-old"><span class="shop_price_value strike">'.$price["old_price"].' '.$result["result"]["currency"].'</span></span>';
			}
            else {
                //echo '<div class="shop_old_price">&nbsp;</div>';
            }
			if (! $price["count"] && empty($hide_submit) || empty($price["price_no_format"]) && ! $result['result']["buy_empty_price"])
			{
				echo '<span class="js_shop_no_buy shop_no_buy">'.$this->diafan->_('Товар ожидается').'</span>';
				$waitlist = true;
			}
			echo '</span>';
		echo '</div>';
	}

	//print_r($result["row"]["param_multiple"]);

	echo '<div class="addict-parent">';

	echo '<div class="addict-field addict-field-coffee" >';
		echo '<div class="js_shop_form_param shop_form_param">';
		foreach ($result["result"]["depends_param"] as $param)
		{
			if(! empty($result["row"]["param_multiple"][$param["id"]]))
			{
				if(count($result["row"]["param_multiple"][$param["id"]]) == 1)
				{
					foreach ($result["row"]["param_multiple"][$param["id"]] as $value => $depend)
					{
						echo '<input type="hidden" name="param'.$param["id"].'" value="'.$value.'"'.($depend == 'depend' ? ' class="depend_param js_shop_depend_param"' : '').'>';
					}
				}
				else
				{
					$select = '';
					foreach ($param["values"] as $value)
					{
						if(! empty($result["row"]["param_multiple"][$param["id"]][$value["id"]]))
						{
							if(! $select)
							{
								$select = '<div class="option-list-param option-list-param'.$param["id"].'">'.$param["name"].'<select name="param'.$param["id"].'" class="shop-dropdown inpselect'.($result["row"]["param_multiple"][$param["id"]][$value["id"]] == 'depend' ? ' depend_param js_shop_depend_param' : '').'">';
							}

							$select .= '<option value="'.$value["id"].'"'
							.(! empty($value["selected"]) ? ' selected' : '')
							.'>'.$value["name"].'</option>';
						}
					}
					if($select)
					{
						echo $select.'</select></div>';
					}
				}
			}
		}
		echo '</div>';
	echo '</div>';
}

if(! empty($result["row"]["additional_cost"]))
{
	$rand = rand(0, 9999);
	echo '<div class="js_shop_additional_cost shop_additional_cost">';
	foreach($result["row"]["additional_cost"] as $r)
	{
		echo '<div class="shop_additional_cost_block"><input type="checkbox" name="additional_cost[]" value="'.$r["id"].'" id="shop_additional_cost_'.$result["row"]["id"].'_'.$r["id"].'_'.$rand.'" summ="';
		if(! $r["percent"] && $r["summ"])
		{
			echo $r["summ"];
		}
		echo '"> <label for="shop_additional_cost_'.$result["row"]["id"].'_'.$r["id"].'_'.$rand.'">'.$r["name"];
		if($r["percent"])
		{
			foreach ($result["row"]["price_arr"] as $price)
			{
				$param_code = '';
				foreach ($price["param"] as $p)
				{
					if($p["value"])
					{
						$param_code .= ' param'.$p["id"].'="'.$p["value"].'"';
					}
				}
				echo '<div class="js_shop_additional_cost_price" summ="'.$r["price_summ"][$price["price_id"]].'"'.$param_code.'>';
				echo ' <b>+'.$r["format_price_summ"][$price["price_id"]].' '.$result["result"]["currency"].'</b></div>';
			}
		}
		elseif($r["summ"])
		{
			echo ' <div class="js_shop_additional_cost" summ="'.$r["summ"].'"><b>+'.$r["format_summ"].' '.$result["result"]["currency"].'</b></div>';
		}
		echo '</label></div>';
	}
	echo '</div>';
}

if(! empty($waitlist))
{
	echo '
	<div class="js_shop_waitlist shop_waitlist"><p>
		'.$this->diafan->_('Сообщить когда появится на e-mail').'</p>
		<div class="input-group"><input type="email" class="form-control input-sm" name="mail" value="'.$this->diafan->_users->mail.'">
			<span class="input-group-btn"><input type="button" class="btn btn-warning btn-sm" value="'.$this->diafan->_('Ок', false).'" action="wait"></span></div>
		<div class="errors error_waitlist" style="display:none"></div>
	</div>';
}

echo '<div class="js_shop_buy shop_buy to-cart">';
    echo '<div class="buttons-wrapper">';
	if (empty($result["row"]['is_file']) && empty($hide_submit))
	{
		echo '<div><span class="do-minus"><</span><input type="text" autofocus min="1" value="1" name="count" class="number form-control" pattern="[0-9]+([\.|,][0-9]+)?" step="any"><span class="do-plus">></span></div>';
	}
	if(empty($hide_submit))
	{
		echo '
		<div class="button-buy-coffee">
			<input type="button" class="btn btn-warning btn-sm btn-buys" value="'.$this->diafan->_('В корзину', false).'" action="buy">
		</div>';
	}
    echo '</div>';

if(empty($hide_submit) && !empty($result["result"]["one_click"]))
	{
		//echo '<button type="button" class="btn btn-default btn-default_mod" action="one_click" role="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-hand-pointer-o"></i> купить в 1 клик</button></div><div style="clear:both;">';
	}
echo '</div>';
echo '</div>';


echo '<div class="error"';
if (! empty($result["row"]["count_in_cart"]))
{
    echo '>'.$this->diafan->_('В корзине %s шт.<br><a class="link_order" href="%s">Оформить</a>', true, $result["row"]["count_in_cart"], BASE_PATH_HREF.$result["result"]["cart_link"]);
}
else
{
    echo ' style="display:none;">';
}
echo '</div>';


echo '</form>';

//форма быстрого заказа
echo '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Обратный звонок</h4>
			</div>
			<div class="modal-body">';
			if(! empty($result["result"]["one_click"]))
			{
				$result["result"]["one_click"]["good_id"] = $result["row"]["id"];
				echo $this->get('one_click', 'cart', $result["result"]["one_click"]);
			}
			echo '</div>
		</div>
	</div>
</div>';

