<?php
/**
 * Обработка POST-запросов в административной части модуля
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */
if ( ! defined('DIAFAN'))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

/**
 * Shop_admin_action
 */
class Shop_admin_action extends Action_admin
{
	/**
	 * Вызывает обработку POST-запросов
	 * 
	 * @return void
	 */
	public function init()
	{
		if ( ! empty($_POST["action"]))
		{
			switch ($_POST["action"])
			{
				case 'show_discount_goods':
					$this->show_discount_goods();
					break;

				case 'discount_good':
					$this->discount_good();
					break;

				case 'delete_discount_good':
					$this->delete_discount_good();
					break;

				case 'show_order_goods':
					$this->show_order_goods();
					break;

				case 'add_order_good':
					$this->add_order_good();
					break;

				case 'new_order':
					$this->new_order();
					break;

				case 'list_site_id':
					$this->list_site_id();
					break;

				case 'param_category_rel':
				case 'param_category_unrel':
					$this->param_category();
					break;

				case 'brand_category_rel':
				case 'brand_category_unrel':
					$this->brand_category();
					break;

				case 'group_no_buy':
				case 'group_not_no_buy':
				case 'group_hit':
				case 'group_not_hit':
				case 'group_action':
				case 'group_not_action':
				case 'group_new':
				case 'group_not_new':
					$this->group_option();
					break;

				case 'group_clone':
					$this->group_clone();
					break;
			}
		}
	}

	/**
	 * Подгружает список товаров
	 * 
	 * @return void
	 */
	private function show_discount_goods()
	{
		if (empty($_POST["discount_id"]))
		{
			$_POST["discount_id"] = 0;
		}
		$nastr = 16;
		$list = '';
		if (empty($_POST["page"]))
		{
			$start = 0;
			$page = 1;
			if ( ! isset($_POST["search"]))
			{
				$list .= '<div class="fa fa-close ipopup__close"></div>
				<div class="ipopup__heading">'.$this->diafan->_('Товары').'</div>
				<div class="infofield">'.$this->diafan->_('Поиск').'</div> <input type="text" size="30" class="rel_module_search">
				<div class="rel_all_elements_container">';
			}
		}
		else
		{
			$page = intval($_POST["page"]);
			$start = ($page - 1) * $nastr;
		}
		$list .= '<div class="rel_all_elements">';
		$discount_goods = array();
		if ($_POST["discount_id"])
		{
			$discount_goods = DB::query_fetch_value("SELECT good_id FROM {shop_discount_object} WHERE discount_id=%d", $_POST["discount_id"], "good_id");
		}
		if (! empty($_POST["search"]))
		{
			$count = DB::query_result("SELECT COUNT(*) FROM {shop} WHERE trash='0' AND (LOWER([name]) LIKE LOWER('%%%h%%') OR LOWER(article) LIKE LOWER('%%%h%%'))", $_POST["search"], $_POST["search"]);
			$rows = DB::query_range_fetch_all("SELECT id, [name] FROM {shop} WHERE trash='0' AND (LOWER([name]) LIKE LOWER('%%%h%%') OR LOWER(article) LIKE LOWER('%%%h%%'))", $_POST["search"], $_POST["search"], $start, $nastr);
		}
		else
		{
			$count = DB::query_result("SELECT COUNT(*) FROM {shop} WHERE trash='0'");
			$rows = DB::query_range_fetch_all("SELECT id, [name] FROM {shop} WHERE trash='0'", $start, $nastr);
		}
		foreach ($rows as $row)
		{
			$img = DB::query_fetch_array("SELECT name, folder_num FROM {images} WHERE element_id=%d AND module_name='shop' AND element_type='element' AND trash='0' ORDER BY sort ASC LIMIT 1", $row["id"]);
			$list .= '<div class="rel_module" element_id="'.$row["id"].'">
			<div'.(in_array($row["id"], $discount_goods) ? ' class="rel_module_selected"' : '').'>
			'.($img ? '<a href="javascript:void(0)"><img src="'.BASE_PATH.USERFILES.'/small/'.($img["folder_num"] ? $img["folder_num"].'/' : '').$img["name"].'"></a><br>' : '').'
			<a href="javascript:void(0)">'.$row["name"].'</a>
			</div>
			</div>';
		}
		$list .= '</div><div class="rel_module_navig paginator">';
		for ($i = 1; $i <= ceil($count / $nastr); $i ++ )
		{
			if ($i != $page)
			{
				$list .= '<a href="javascript:void(0)" page="'.$i.'">'.$i.'</a> ';
			}
			else
			{
				$list .= '<span class="active">'.$i.'</span>';
			}
		}
		$list .= '</div>';
		if (empty($_POST["page"]) && ! isset($_POST["search"]))
		{
			$list .= '</div>';
		}

		$this->result["data"] = $list;
	}

	/**
	 * Прикрепляет скидку к товару
	 * 
	 * @return void
	 */
	private function discount_good()
	{
		if ( ! $_POST["discount_id"])
		{
			$_POST["discount_id"] = DB::query("INSERT INTO {shop_discount} () VALUES ()");
			$this->result["id"] = $_POST["discount_id"];
		}
		Custom::inc('modules/shop/admin/shop.admin.view.php');
		if ( ! DB::query_result("SELECT id FROM {shop_discount_object} WHERE good_id=%d AND discount_id=%d LIMIT 1", $_POST["good_id"], $_POST["discount_id"]))
		{
			DB::query("INSERT INTO {shop_discount_object} (good_id, discount_id) VALUES (%d, %d)", $_POST["good_id"], $_POST["discount_id"]);
		}

		$shop_admin_view = new Shop_admin_view($this->diafan);
		$this->result["data"] = $shop_admin_view->discount_goods($_POST["discount_id"]);
	}

	/**
	 * Удаляет скидку на товар
	 * 
	 * @return void
	 */
	private function delete_discount_good()
	{
		DB::query("DELETE FROM {shop_discount_object} WHERE good_id=%d AND discount_id=%d", $_POST['good_id'], $_POST['discount_id']);

		$this->diafan->_cache->delete("", $this->diafan->_admin->module);
	}

	/**
	 * Клонирует товар
	 * 
	 * @return void
	 */
	private function group_clone()
	{
		// Проверяет права на редактирование
		if (! $this->diafan->_users->roles('edit', 'shop'))
		{
			return;
		}
		foreach ($_POST["ids"] as $id)
		{
			$id = intval($id);
			if(! $id)
				continue;

			$row = DB::query_fetch_array("SELECT * FROM {shop} WHERE id=%d LIMIT 1", $id);
	
			foreach ($row as $k => $v)
			{
				if ($k == 'name'.$this->diafan->_languages->site)
				{
					$v = $this->diafan->_('КОПИЯ').' '.$v;
				}
				$row[$k] = "'".str_replace("'", "\\'", $v)."'";
			}
			unset($row['id']);
			unset($row['counter_buy']);
	
			$n_id = DB::query('INSERT INTO {shop} ('.implode(',', array_keys($row)).') VALUES ('.implode(',', $row).')');
	
			$site_id = $row['site_id'];
	
			$rows = DB::query_fetch_all("SELECT cat_id, trash FROM {shop_category_rel} WHERE element_id='%d'", $id);
			foreach ($rows as $row)
			{
				DB::query("INSERT INTO {shop_category_rel} (element_id, cat_id, trash) VALUES (%d, %d, '%s')", $n_id, $row['cat_id'], $row['trash']);
			}
			
			$prices = array();
			$rows = DB::query_fetch_all("SELECT * FROM {shop_price} WHERE good_id=%d AND trash='0'", $id);
			foreach ($rows as $row)
			{
				$row['good_id'] = $n_id;
				$row_param = array();
				foreach ($row as $k => $v)
				{
					if($k != "id")
					{
						$row_param[$k] = "'".str_replace("'", "\\'", $v)."'";
					}
				}
				$price_id = DB::query('INSERT INTO {shop_price} ('.implode(',', array_keys($row_param)).') VALUES ('.implode(',', $row_param).')');
				if($row["id"] == $row["price_id"])
				{
					$prices[$row["price_id"]] = $price_id;
	
					$rows_param = DB::query_fetch_all("SELECT param_id, param_value FROM {shop_price_param} WHERE price_id=%d", $row["price_id"]);
					foreach ($rows_param as $row_param)
					{
						DB::query("INSERT INTO {shop_price_param} (price_id, param_id, param_value) VALUES (%d, %d, %d)", $price_id, $row_param["param_id"], $row_param["param_value"]);
					}
				}
			}
			foreach ($prices as $old => $new)
			{
				DB::query("UPDATE {shop_price} SET price_id=%d WHERE price_id=%d AND good_id=%d", $new, $old, $n_id);
			}
	
			$rows = DB::query_fetch_all("SELECT * FROM {images} WHERE element_id=%d AND element_type='element' AND module_name='shop' AND trash='0'", $id);
			foreach ($rows as $row)
			{
				$n = array();
				$m = array();
				$vs = array();
				foreach($row as $k => $v)
				{
					if($k == 'id')
						continue;
		
					$n[] = $k;
					switch($k)
					{
						case 'element_id':
							$m[] = "%d";
							$vs[] = $n_id;
							break;
		
						case 'tmpcode':
							$m[] = "''";
							break;
		
						case 'image_id':
							if($v)
							{
								$vs[] = $v;
							}
							else
							{
								$vs[] = $row["id"];
							}
							$m[] = "%d";
							break;
						
						case 'created':
							$m[] = "%d";
							$vs[] = time();
							break;
		
						default:
							$m[] = "'%s'";
							$vs[] = $v;
					}
				}
				DB::query("INSERT INTO {images} (".implode(",", $n).") VALUES (".implode(",", $m).")", $vs);
			}
	
			$rows = DB::query_fetch_all("SELECT * FROM {shop_param_element} WHERE element_id='%d' AND trash='0'", $id);
			foreach ($rows as $row)
			{
				unset($row["id"]);
				$row['element_id'] = $n_id;
				foreach ($row as $k => &$v)
				{
					$v = "'".str_replace("'", "\\'", $v)."'";
				}
				DB::query('INSERT INTO {shop_param_element} ('.implode(',', array_keys($row)).') VALUES ('.implode(',', $row).')');
			}
		}

		$this->result["redirect"] = URL;
	}

	/**
	 * Подгружает список товаров для добавления в заказ
	 * 
	 * @return void
	 */
	private function show_order_goods()
	{
		if (empty($_POST["order_id"]))
		{
			$_POST["order_id"] = 0;
		}
		$nastr = 18;
		$list = '';
		if (empty($_POST["page"]))
		{
			$start = 0;
			$page = 1;
			if ( ! isset($_POST["search"]) && ! isset($_POST["cat_id"]))
			{
				$list .= '<div class="fa fa-close ipopup__close"></div>
				<div class="ipopup__heading">'.$this->diafan->_('Товары').'</div>
				<form>
				<div class="infofield">'.$this->diafan->_('Поиск').'</div> <input type="text" size="30" class="order_goods_search">
				';

				if($this->diafan->configmodules("cat", "shop"))
				{
					$cats = DB::query_fetch_key_array("SELECT id, [name], parent_id FROM {shop_category} WHERE trash='0' ORDER BY sort ASC", "parent_id");
					$vals = array();
					if(! empty($_POST["cat_id"]))
					{
						$vals[] = $this->diafan->filter($_POST, "int", "cat_id");
					}
					$list.= ' <select name="cat_id" class="order_goods_cat_id"><option value="">'.$this->diafan->_('Все').'</option>'.$this->diafan->get_options($cats, $cats[0], $vals).'</select>';
				}
				$list.= '</form><div class="order_all_goods_container">';
			}
		}
		else
		{
			$page = intval($_POST["page"]);
			$start = ($page - 1) * $nastr;
		}
		$list .= '<div class="rel_all_elements">';

		$where = '';
		if(! empty($_POST["cat_id"]))
		{
			$where = " AND cat_id=".$this->diafan->filter($_POST, "int", "cat_id");
		}
		$where .= " ORDER BY sort DESC";

		if ( ! empty($_POST["search"]))
		{
			$count = DB::query_result("SELECT COUNT(*) FROM {shop} WHERE trash='0' AND (LOWER([name]) LIKE LOWER('%%%h%%') OR LOWER(article) LIKE LOWER('%%%h%%'))".$where, $_POST["search"], $_POST["search"]);
			$rows = DB::query_range_fetch_all("SELECT id, [name] FROM {shop} WHERE trash='0' AND (LOWER([name]) LIKE LOWER('%%%h%%') OR LOWER(article) LIKE LOWER('%%%h%%'))".$where, $_POST["search"], $_POST["search"], $start, $nastr);
		}
		else
		{
			$count = DB::query_result("SELECT COUNT(*) FROM {shop} WHERE trash='0'".$where);
			$rows = DB::query_range_fetch_all("SELECT id, [name] FROM {shop} WHERE trash='0'".$where, $start, $nastr);
		}
		$user_id = DB::query_result("SELECT user_id FROM {shop_order} WHERE id=%d LIMIT 1", $_POST["order_id"]);
		foreach ($rows as $row)
		{
			$this->diafan->_shop->price_prepare_base($row["id"]);
			$ids[] = $row["id"];
		}
		$param_select_ids = array();
		foreach($rows as $row)
		{
			$prices = $this->diafan->_shop->price_get_base($row["id"]);
			foreach($prices as $pr)
			{
				if(! empty($pr["param"]))
				{
					foreach($pr["param"] as $p)
					{
						if(! in_array($p, $param_select_ids))
						{
							$param_select_ids[] = $p;
						}
					}
				}
			}
		}
		if($param_select_ids)
		{
			$param_select = DB::query_fetch_key_value("SELECT id, [name] FROM {shop_param_select} WHERE id IN (%s)", implode(",", $param_select_ids), "id", "name");
		}
		if($rows)
		{
			$imgs = DB::query_fetch_key("SELECT name, folder_num, element_id FROM {images} WHERE element_id IN(%s) AND module_name='shop' AND element_type='element' AND trash='0' ORDER BY sort DESC", implode(',', $ids), "element_id");
		}
		foreach ($rows as $row)
		{
			$prices = $this->diafan->_shop->price_get_base($row["id"]);
			$list .= '<div class="rel_module order_good">
			<div>';
			if(! empty($imgs[$row["id"]]))
			{
				$list .= '<img src="'.BASE_PATH.USERFILES.'/small/'.($imgs[$row["id"]]["folder_num"] ? $imgs[$row["id"]]["folder_num"].'/' : '').$imgs[$row["id"]]["name"].'">';
			}
			if(count($prices) > 1)
			{
				$list .= '<a href="javascript:void(0)" class="order_good_show_price">'.$row["name"].'</a>';
				$list .= '<div class="order_good_all_price hide"><div class="fa fa-close order_good_price_close"></div>';
				foreach ($prices as $price)
				{
					if($price["param"])
					{
						$k = 0;
						foreach($price["param"] AS $p)
						{
							if(! empty($param_select[$p]))
							{
								if($k > 0)
								{
									$list .= ', ';
								}
								$list .= $param_select[$p];
							}
							$k++;
						}
					}
					$list .= ' <a href="javascript:void(0)" price_id="'.$price["id"].'" class="order_good_add">'.$this->diafan->_shop->price_format($price["price"]).' '.$this->diafan->configmodules("currency", "shop").'</a><br>';
				}
				$list .= '</div>';
			}
			else
			{
				$price = $prices[0];
				$list .= ' <a href="javascript:void(0)" price_id="'.$price["id"].'" class="order_good_add">'.$row["name"].'<br>'.$this->diafan->_shop->price_format($price["price"]).' '.$this->diafan->configmodules("currency", "shop").'</a>';
			}
			$list .= '</div>
			</div>';
		}
		$list .= '</div><div class="paginator order_goods_navig">';
		for ($i = 1; $i <= ceil($count / $nastr); $i ++ )
		{
			if ($i != $page)
			{
				$list .= '<a href="javascript:void(0)" page="'.$i.'">'.$i.'</a> ';
			}
			else
			{
				$list .= '<span class="active">'.$i.'</span> ';
			}
		}
		$list .= '</div>';
		if (empty($_POST["page"]) && ! isset($_POST["search"]))
		{
			$list .= '</div>';
		}

		$this->result["data"] = $list;
	}

	/**
	 * Добавляет выбранный товар в заказ
	 * 
	 * @return void
	 */
	private function add_order_good()
	{
		if(! $this->diafan->_users->roles('edit', 'shop/order'))
		{
			return;
		}
		if (empty($_POST["price_id"]))
		{
			return;
		}
		$format_price = intval($this->diafan->configmodules("format_price_1", "shop"));
		$price = DB::query_fetch_array("SELECT price_id, price, old_price, good_id, discount_id, id FROM {shop_price} WHERE id=%d LIMIT 1", $_POST["price_id"]);
		$where = array();
		$params = array();
		$rows = DB::query_fetch_all("SELECT param_id, param_value FROM {shop_price_param} WHERE price_id=%d AND trash='0'", $price["price_id"]);
		foreach ($rows as $row)
		{
			$params[$row["param_id"]] = $row["param_value"];
			$where[] = "s.param_id=".intval($row["param_id"])." AND s.value=".intval($row["param_value"]);
		}
		$depend = '';
		if($params)
		{
			foreach ($params as $id => $value)
			{
				if(! $value)
					continue;
				$param_name  = DB::query_result("SELECT [name] FROM {shop_param} WHERE id=%d LIMIT 1", $id);
				$param_value = DB::query_result("SELECT [name] FROM {shop_param_select} WHERE id=%d LIMIT 1", $value);
				$depend .= ($depend ? ', ' : '').$param_name.': '.$param_value;
			}
		}
		$good = DB::query_fetch_array("SELECT [name], article, cat_id, [measure_unit] FROM {shop} WHERE id=%d LIMIT 1", $price["good_id"]);
		$img = DB::query_fetch_array("SELECT i.name, i.folder_num FROM {images} AS i
		LEFT JOIN {shop_price_image_rel} AS r ON r.image_id=i.id AND r.price_id=%d
		WHERE i.element_id=%d AND i.module_name='shop' AND i.element_type='element' AND i.trash='0'
		ORDER BY r.image_id DESC LIMIT 1",
		$price["price_id"], $price["good_id"]);

		$old_price = $price["old_price"] ? $price["old_price"] : $price["price"];
		if($price["discount_id"])
		{
			$d = DB::query_fetch_array("SELECT discount, deduction FROM {shop_discount} WHERE id=%d LIMIT 1", $price["discount_id"]);
			$discount = $d["discount"] ? $d["discount"].'%' : $d["deduction"].' '.$this->diafan->configmodules("currency", "shop");
		}
		$cat_name = $good["cat_id"] ? DB::query_result("SELECT [name] FROM {shop_category} WHERE id=%d", $good["cat_id"]) : '';

		$this->result["data"] = '
		<li class="item">
		<div class="item__in">
			<div class="sum no_important ipad">'.($img ? '<img src="'.BASE_PATH.USERFILES.'/small/'.($img["folder_num"] ? $img["folder_num"].'/' : '').$img["name"].'">' : '').'</div>
			
			<div class="name"><a href="'.BASE_PATH_HREF.'shop/edit'.$price["good_id"].'/">'.$good["name"].' '.$depend.' ('.$good["article"].')</a>
			<input type="hidden" name="new_goods[]" value="'.$price["id"].'">
			<div class="categories">'.$cat_name.'</div></div>
			
			<div class="item__adapt mobile">
				<i class="fa fa-bars"></i>
				<i class="fa fa-caret-up"></i>
			</div>
			<div class="item__seporator mobile"></div>
								
			<div class="num no_important ipad"><nobr><input type="text" name="new_count_goods[]" value="1" size="2">';
			if($good["measure_unit"])
			{
				$this->result["data"] .= ' '.$good["measure_unit"];
			}
			$this->result["data"] .= '</nobr></div>
			
			<div class="num no_important ipad">'.$this->diafan->_shop->price_format($old_price).'</div>
			
			<div class="num no_important ipad">'.($price["discount_id"] ? '<a href="'.BASE_PATH_HREF.'shop/discount/edit'.$price["discount_id"].'/">'.$discount.'</a>' : '').'</div>
			
			<div class="num no_important ipad"><input type="text" name="new_price_goods[]" value="'.number_format($price["price"], $format_price, ".", "").'" size="4"></div>
			
			<div class="num">'.$this->diafan->_shop->price_format($price["price"]).'</div>
			
			<div class="num"><a href="javascript:void(0)" confirm="'.$this->diafan->_('Вы действительно хотите удалить товар из заказа?').'" class="delete delete_order_good"><i class="fa fa-close" title="'.$this->diafan->_('Удалить').'"></i></a></div>

		</div>';
		$additional_costs = DB::query_fetch_all("SELECT a.id, a.[name], a.price, a.percent, r.summ, r.element_id FROM {shop_additional_cost} AS a
		INNER JOIN {shop_additional_cost_rel} AS r ON r.element_id=%d AND r.additional_cost_id=a.id
		WHERE a.trash='0' AND a.shop_rel='1'
		ORDER BY a.sort ASC", $price["good_id"]);
		foreach($additional_costs as $a)
		{
			if($a["percent"])
			{
				$a["summ"] = ($price["price"] * $a["percent"]) / 100;
			}
			elseif(! $a["summ"])
			{
				$a["summ"] = $a["price"];
			}
			$this->result["data"] .= '
			<div class="item__in">
				<div class="sum no_important ipad"></div>
				
				<div class="name">'.$a["name"].'</div>
				
				<div></div>
				<div></div>
				<div></div>
				
				<div class="num">
				<input name="additional_cost_id_price_'.$price["id"].'_'.$a["id"].'" id="additional_cost_id_price_'.$price["id"].'_'.$a["id"].'" value="1" type="checkbox" title="'.$this->diafan->_('Добавлено к заказу').'">
				<label for="additional_cost_id_price_'.$price["id"].'_'.$a["id"].'">
				<input type="text" name="summ_additional_cost_price_'.$price["id"].'_'.$a["id"].'" value="'.number_format($a["summ"], $format_price, ".", "").'" size="4"></label></div>
				
				<div class="num no_important ipad">'.number_format($a["summ"], $format_price, ".", "").'
				</div>
				<div class="num no_important ipad"></div>
			</div>';
		}
		$this->result["data"] .= '</li>';
	}

	/**
	 * Проверяет наличие новых заказов
	 * 
	 * @return void
	 */
	private function new_order()
	{
		$last_order_id = $this->diafan->filter($_POST, "int", "last_order_id");

		$this->result["next_order_id"] = DB::query_result("SELECT id FROM {shop_order} WHERE id>%d AND trash='0' LIMIT 1", $last_order_id);
	}

	/**
	 * Подгружает список модулей
	 * 
	 * @return void
	 */
	private function list_site_id()
	{
		if (! $_POST["parent_id"])
		{
			$list = '<div class="fa fa-close ipopup__close"></div>
			<div class="menu_list menu_list_first"><div class="ipopup__heading">'.$this->diafan->_('Страницы сайта').'</div>';
		}
		else
		{
			$list = '<div class="menu_list">';
		}
		
		$rows = DB::query_fetch_all("SELECT id, [name], module_name, count_children FROM {site} WHERE [act]='1' AND trash='0' AND parent_id=%d ORDER BY sort ASC", $_POST["parent_id"]);
		foreach ($rows as $row)
		{
			$list .= '<p site_id="'.$row["id"].'" module_name="site" element_id="" cat_id="">';
			if ($row["count_children"])
			{
				$list .= '<a href="javascript:void(0)" class="plus menu_plus">+</a>';
			}
			else
			{
				$list .= '&nbsp;&nbsp;';
			}
			$list .= '&nbsp;<a href="'.BASE_PATH_HREF.'site/edit'.$row["id"].'/" class="menu_select">'.$row["name"].'</a></p>';
		}
		$list .= '</div>';

		$this->result["data"] = $list;
	}

	/**
	 * Прикрепляет/открепляет характеристику к категории
	 * 
	 * @return void
	 */
	private function param_category()
	{
		if(! empty($_POST["cat_id"]) || ! empty($_POST["ids"]))
		{
			$ids = array();
			foreach ($_POST["ids"] as $id)
			{
				$id = intval($id);
				if($id)
				{
					$ids[] = $id;
				}
			}
			if($ids)
			{
				if($_POST["action"] == 'param_category_rel')
				{
					DB::query("DELETE FROM {shop_param_category_rel} WHERE element_id IN(%s) AND cat_id IN(%d, 0)", implode(",", $ids), $_POST["cat_id"]);
				}
				else
				{
					DB::query("DELETE FROM {shop_param_category_rel} WHERE element_id IN(%s) AND cat_id=%d", implode(",", $ids), $_POST["cat_id"]);
				}
			}
			if($_POST["action"] == 'param_category_rel')
			{
				foreach ($ids as $id)
				{
					DB::query("INSERT INTO {shop_param_category_rel} (element_id, cat_id) VALUES (%d, %d)", $id, $_POST["cat_id"]);
				}
			}
			else
			{
				// выбираем все характеристики из выделенных, которые прикреплены к каким-нибудь категориям
				$cats_rel = DB::query_fetch_value("SELECT DISTINCT(element_id) FROM {shop_param_category_rel} WHERE element_id IN (%s)", implode(",", $ids), "element_id");
				// если характеристика не прикреплена ни к одной категории, делаем ее общей
				foreach($ids as $id)
				{
					if(! in_array($id, $cats_rel))
					{
						DB::query("INSERT INTO {shop_param_category_rel} (element_id) VALUES (%d)", $id);
					}
				}
			}
		}
		$this->result["redirect"] = URL;
	}

	/**
	 * Прикрепляет/открепляет характеристику к производителю
	 * 
	 * @return void
	 */
	private function brand_category()
	{
		if(! empty($_POST["cat_id"]) || ! empty($_POST["ids"]))
		{
			$ids = array();
			foreach ($_POST["ids"] as $id)
			{
				$id = intval($id);
				if($id)
				{
					$ids[] = $id;
				}
			}
			if($ids)
			{
				if($_POST["action"] == 'brand_category_rel')
				{
					DB::query("DELETE FROM {shop_brand_category_rel} WHERE element_id IN(%s) AND cat_id IN(%d, 0)", implode(",", $ids), $_POST["cat_id"]);
				}
				else
				{
					DB::query("DELETE FROM {shop_brand_category_rel} WHERE element_id IN(%s) AND cat_id=%d", implode(",", $ids), $_POST["cat_id"]);
				}
			}
			if($_POST["action"] == 'brand_category_rel')
			{
				foreach ($ids as $id)
				{
					DB::query("INSERT INTO {shop_brand_category_rel} (element_id, cat_id) VALUES (%d, %d)", $id, $_POST["cat_id"]);
				}
			}
			else
			{
				// выбираем все производители из выделенных, которые прикреплены к каким-нибудь категориям
				$cats_rel = DB::query_fetch_value("SELECT DISTINCT(element_id) FROM {shop_brand_category_rel} WHERE element_id IN (%s)", implode(",", $ids), "element_id");
				// если характеристика не прикреплена ни к одной категории, делаем ее общей
				foreach($ids as $id)
				{
					if(! in_array($id, $cats_rel))
					{
						DB::query("INSERT INTO {shop_brand_category_rel} (element_id) VALUES (%d)", $id);
					}
				}
			}
		}
		$this->result["redirect"] = URL;
	}

	/**
	 * Групповая операция "Товар временно отсутствует", "Акция" и др.
	 * 
	 * @return void
	 */
	private function group_option()
	{
		if(! empty($_POST["ids"]))
		{
			$ids = array();
			foreach ($_POST["ids"] as $id)
			{
				$id = intval($id);
				if($id)
				{
					$ids[] = $id;
				}
			}
		}
		elseif(! empty($_POST["id"]))
		{
			$ids = array(intval($_POST["id"]));
		}
		if(! empty($ids))
		{
			switch ($_POST["action"])
			{
				case 'group_no_buy':
					$set = "no_buy='1'";
					$this->result["img"] = BASE_PATH.'adm/img/no_buy.png';
					$this->result["action"] = 'group_not_no_buy';
					break;

				case 'group_not_no_buy':
					$set = "no_buy='0'";
					$this->result["img"] = BASE_PATH.'adm/img/no_buy_noact.png';
					$this->result["action"] = 'group_no_buy';
					break;

				case 'group_hit':
					$set = "hit='1'";
					$this->result["img"] = BASE_PATH.'adm/img/hit.png';
					$this->result["action"] = 'group_not_hit';
					break;

				case 'group_not_hit':
					$set = "hit='0'";
					$this->result["img"] = BASE_PATH.'adm/img/hit_noact.png';
					$this->result["action"] = 'group_hit';
					break;

				case 'group_action':
					$set = "action='1'";
					$this->result["img"] = BASE_PATH.'adm/img/action.png';
					$this->result["action"] = 'group_not_action';
					break;

				case 'group_not_action':
					$set = "action='0'";
					$this->result["img"] = BASE_PATH.'adm/img/action_noact.png';
					$this->result["action"] = 'group_action';
					break;

				case 'group_new':
					$set = "new='1'";
					$this->result["img"] = BASE_PATH.'adm/img/new.png';
					$this->result["action"] = 'group_not_new';
					break;

				case 'group_not_new':
					$set = "new='0'";
					$this->result["img"] = BASE_PATH.'adm/img/new_noact.png';
					$this->result["action"] = 'group_new';
					break;
			}
			if($ids)
			{
				DB::query("UPDATE {shop} SET ".$set." WHERE id IN (%s)", implode(",", $ids));
				$this->diafan->_cache->delete("", "shop");
			}
		}

		$this->result["redirect"] = URL;
	}
}
