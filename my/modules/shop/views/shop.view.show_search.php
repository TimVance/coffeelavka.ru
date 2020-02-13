<?php
/**
 * Шаблон форма поиска по товарам
 *
 * Шаблонный тег <insert name="show_search" module="shop"
 * [cat_id="категория"] [site_id="страница_с_прикрепленным_модулем"]
 * [ajax="подгружать_результаты"]
 * [only_module="только_на_странице_модуля"] [template="шаблон"]>:
 * форма поиска по товарам
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

echo '<div class="row block shop-search">';
// echo '<h3>'.$this->diafan->_('Поиск по товарам').'</h3>';

echo '<form method="GET" action="'.BASE_PATH_HREF.$result["path"].'" class="js_shop_search_form'.(! empty($result["send_ajax"]) ? ' ajax' : '').'">';
echo '<input type="hidden" name="module" value="shop">
<input type="hidden" name="action" value="search">';

if (count($result["site_ids"]) > 1)
{
	echo '<div class="shop_search_site_ids">
	<span class="input-title">'.$this->diafan->_('Раздел').':</span>
	<select class="js_shop_search_site_ids">';
	foreach ($result["site_ids"] as $row)
	{
		echo '<option value="'.$row["id"].'" path="'.BASE_PATH_HREF.$row["path"].'"';
		if($result["site_id"] == $row["id"])
		{
			echo ' selected';
		}
		echo '>'.$row["name"].'</option>';
	}
	echo '</select>';
	echo '</div>';
}

if (count($result["cat_ids"]) > 1)
{
	echo '<div class="col-md-12 shop_search_cat_ids">
	<label class="input-title">'.$this->diafan->_('Категория').':</label>
	<select name="cat_id" class="form-control js_shop_search_cat_ids">';
	echo '<option value="">'.$this->diafan->_('Все').'</option>';
	foreach ($result["cat_ids"] as $row)
	{
		echo '<option  value="'.$row["id"].'" site_id="'.$row["site_id"].'"';
		if($result["cat_id"] == $row["id"])
		{
			echo ' selected';
		}
		echo '>';
		if($row["level"])
		{
			echo str_repeat('- ', $row["level"]);
		}
		echo $row["name"].'</option>';
	}
	echo '</select>';
	echo '</div>';
}
else
{
	echo '<input name="cat_id" type="hidden" value="'.$result["cat_id"].'">';
}

if (! empty($result["article"]))
{
	echo '<div class="col-md-12 shop_search_article">
		<label class="input-title">'.$this->diafan->_('Артикул').':</label>
		<input type="text" class="form-control width-full" name="a" value="'.$result["article"]["value"].'">
	</div>';
}

if (! empty($result["price"]))
{
	echo '<div class="shop_search_price form-group">
		<div class="col-md-12">
		<label class="input-title">'.$this->diafan->_('Цена').':</label><br>
			<input type="text" class="from form-control" name="pr1" value="'.$result["price"]["value1"].'" style="max-width:44%;display:inline;">
			&nbsp;-&nbsp;
			<input type="text" class="to form-control" name="pr2" value="'.$result["price"]["value2"].'" style="max-width:44%;display:inline;">
		</div>
	</div>';
}

if (! empty($result["brands"]))
{
	echo '<div class="col-md-12"><div class="checkbox shop_search_brand">
	<span class="input-title">'.$this->diafan->_('Производитель').':</span>';
	foreach ($result["brands"] as $row)
	{
		echo '<div class="js_shop_search_brand" site_id="'.$row["site_id"].'">
		<label for="shop_search_brand'.$row["id"].'"><input type="checkbox" name="brand[]" value="'.$row["id"].'"';
		if(in_array($row["id"], $result["brand"]))
		{
			echo ' checked';
		}
		echo ' id="shop_search_brand'.$row["id"].'"> '.$row["name"].'</label></div>';
	}
	echo '</div></div>';
}

if (! empty($result["action"]))
{
	echo '<div class="col-md-12"><div class="shop_search_action checkbox">
	<label for="shop_search_ac">
		<input type="checkbox" name="ac" id="shop_search_ac" value="1"'.($result["action"]["value"] ? ' checked' : '').'>
		'.$this->diafan->_('Товар по акции').'</label>
	</div>';
}

if (!empty($result["new"]))
{
	echo '<div class="shop_search_new checkbox">
		<label for="shop_search_ne"><input type="checkbox" name="ne" id="shop_search_ne" value="1"'.($result["new"]["value"] ? ' checked' : '').'>
		'.$this->diafan->_('Новинка').'</label>
	</div>';
}

if (!empty($result["hit"]))
{
	echo '<div class="shop_search_hit checkbox"><label for="shop_search_hit">
		<input type="checkbox" name="hi" id="shop_search_hit" value="1"'.($result["hit"]["value"] ? ' checked' : '').'>
		'.$this->diafan->_('Хит').'</label>
	</div></div>';
}

if (!empty($result["rows"]))
{
	foreach ($result["rows"] as $row)
	{
		echo '<div class="col-md-12 js_shop_search_param shop_search_param shop_search_param'.$row["id"].'" cat_ids="'.$row["cat_ids"].'">';
		switch ($row["type"])
		{
			case 'title':
				echo '<label class="input-title">'.$row["name"].':</label><br>';
				break;

			case 'date':
				echo '
				<label class="input-title">'.$row["name"].':</label>
				<div class="col-md-2">
					<input type="text" name="p'.$row["id"].'_1" value="'.$row["value1"].'" class="from timecalendar form-control" showTime="false">
					&nbsp;-&nbsp;
					<input type="text" name="p'.$row["id"].'_2" value="'.$row["value2"].'" class="to timecalendar form-control" showTime="false">
				</div>';
				break;

			case 'datetime':
				echo '
				<label class="input-title">'.$row["name"].':</label>
				<div class="col-md-2">
					<input type="text" name="p'.$row["id"].'_1" value="'.$row["value1"].'" class="from timecalendar form-control" showTime="true">
					&nbsp;-&nbsp;
					<input type="text" name="p'.$row["id"].'_2" value="'.$row["value2"].'" class="to timecalendar form-control" showTime="true">
				</div>';
				break;

			case 'numtext':
				echo '
				<label class="input-title">'.$row["name"].':</label>
				<div class="col-md-2">
					<input type="text" class="from form-control" name="p'.$row["id"].'_1" value="'. $row["value1"].'">
					&nbsp;-&nbsp;
					<input type="text" class="to form-control"  name="p'.$row["id"].'_2" value="'.$row["value2"].'">
				</div>';
				break;

			case 'checkbox':
				echo '
				<label for="shop_search_p'.$row["id"].'">'.$row["name"].'</label><br>
				<div class="col-md-2"><input type="checkbox" id="shop_search_p'.$row["id"].'" name="p'.$row["id"].'" value="1"'.($row["value"] ? " checked" : '').'>
				</div>';
				break;

			case 'select':
			case 'multiple':
				echo '
				<label class="input-title">'.$row["name"].':</label>';
				foreach ($row["select_array"] as $key => $value)
				{
					echo '<div class="checkbox"><label for="shop_search_p'.$row["id"].'_'.$key.'"><input ckass="form-control" type="checkbox" id="shop_search_p'.$row["id"].'_'.$key.'" name="p'.$row["id"].'[]" value="'.$key.'"'.(in_array($key, $row["value"]) ? " checked" : '').'>
					'.$value.'</label></div>
					';
				}
		}
		echo '
		</div>';
	}
}
echo '
	<div class="col-md-2"><br>
	<input class="btn btn-warning btn-sm" type="submit" value="'.$this->diafan->_('Найти', false).'"></div>
	</form>
</div>';