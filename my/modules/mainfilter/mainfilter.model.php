<?php
/**
 * Модель
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


class Mainfilter_model extends Model
{

    public function __construct(&$diafan)
    {
        $this->diafan = &$diafan;

        $this->person_discount_ids = $this->diafan->_shop->price_get_person_discounts();

        $this->sort_config = $this->expand_sort_with_params();

        if ($this->diafan->_route->sort > count($this->sort_config['sort_directions']))
        {
            Custom::inc('includes/404.php');
        }
    }


    /**
     * Позволяет добавлять характеристики товара  для сортировки
     *
     * @return array
     */
    private function expand_sort_with_params()
    {
        $sort_fields_names = array(1 => $this->diafan->_('Цена', false), 3 => $this->diafan->_('Наименование товара', false));

        $sort_directions = array(
            1 => 'pr.price ASC',
            2 => 'pr.price DESC',
            3 => 's.name'._LANG.' ASC',
            4 => 's.name'._LANG.' DESC'
        );

        $param_ids = array();

        $rows = DB::query_fetch_all("SELECT p.id, p.[name], p.type FROM {shop_param} AS p "
            . " INNER JOIN {shop_param_category_rel} AS cr ON cr.element_id=p.id AND cr.trash='0' "
            . ($this->diafan->_route->cat ? " AND (cr.cat_id=%d OR cr.cat_id=0)" : " AND cr.cat_id=0")
            . " WHERE p.trash='0' AND p.display_in_sort='1' AND p.type IN
		('text', 'numtext', 'date', 'datetime', 'checkbox') GROUP BY p.id ORDER BY p.sort", $this->diafan->_route->cat);

        foreach ($rows as $row)
        {
            switch($row["type"])
            {
                case 'text':
                    $name = 'sp.[value]';
                    break;
                case 'numtext':
                    $name = 'CAST(sp.value'.$this->diafan->_languages->site.' AS SIGNED)';
                    break;
                case 'date':
                case 'datetime':
                case 'checkbox':
                    $name = 'sp.value'.$this->diafan->_languages->site;
                    break;
            }
            $sort_directions[] = ' '.$name.' ASC ';
            $param_ids[count($sort_directions)] = $row['id'];
            $sort_fields_names[count($sort_directions)] = $row['name'];

            $sort_directions[] = ' '.$name.' DESC ';
            $param_ids[count($sort_directions)] = $row['id'];
        }

        $use_params_for_sort = $this->diafan->_route->sort > 4 ? true : false;

        return array('sort_fields_names' => $sort_fields_names, 'sort_directions' => $sort_directions,
                     'param_ids' => $param_ids, 'use_params_for_sort' => $use_params_for_sort);
    }

    public function show_block() {

        $result["params"] = $this->getParams();
        return $result;

    }

    private function getParams() {
        return DB::query_fetch_key_array("
            SELECT p.id AS pid, p.[name] AS pname, s.[name], s.id FROM {shop_param} AS p
            RIGHT JOIN {shop_param_select} AS s
            ON p.id=s.param_id
            WHERE p.mainfilter='1' ORDER BY p.sort
        ", "pid");
    }


    /**
     * Генерирует данные для списка товаров, найденных при помощи поиска
     *
     * @return void
     */
    public function list_search()
    {
        $time = mktime(23, 59, 0, date("m"), date("d"), date("Y"));

        $where_param = '';
        $where = '';
        $values = array();
        $getnav = '';
        $group = '';

        $this->where($where, $where_param, $values, $getnav, $group);

        if($this->diafan->configmodules('where_period_element'))
        {
            $where .= " AND s.date_start<=".$time." AND (s.date_finish=0 OR s.date_finish>=".$time.")";
        }

        ////navigation//
        $this->diafan->_paginator->get_nav = $getnav;
        $this->diafan->_paginator->nen = $this->list_search_query_count($where_param, $where, $group, $values);
        $links = $this->diafan->_paginator->get();
        ////navigation///

        if($this->diafan->_route->cat)
        {
            $cat = DB::query_fetch_array("SELECT view, theme FROM {shop_category} WHERE id=%d AND [act]='1' AND trash='0'", $this->diafan->_route->cat);
            if($cat)
            {
                $this->result["theme"] = $cat["theme"];
                $this->result["view"] = $cat["view"];
            }

        }
        if($this->diafan->configmodules("theme_list_search"))
        {
            $this->result["theme"] = $this->diafan->configmodules("theme_list_search");
        }
        if($this->diafan->configmodules("view_list_search"))
        {
            $this->result["view"] = $this->diafan->configmodules("view_list_search");
        }
        elseif(empty($this->result["view"]))
        {
            $this->result["view"] = 'list';
        }
        $this->result["breadcrumb"] = $this->get_breadcrumb();
        $this->result["titlemodule"] = $this->diafan->_('Поиск по товарам', false);

        if ( ! $this->diafan->_paginator->nen)
        {
            $this->result["error"] = $this->diafan->_('Извините, ничего не найдено.', false);
            return $this->result;
        }

        $this->result["rows"] = $this->list_search_query($where_param, $where, $group, $values);
        $this->elements($this->result["rows"]);

        $this->result["paginator"] = $this->diafan->_tpl->get('get', 'paginator', $links);

        foreach ($this->result["rows"] as &$row)
        {
            $this->prepare_data_element($row);
        }
        foreach ($this->result["rows"] as &$row)
        {
            $this->format_data_element($row);
        }

        $this->result["link_sort"] = $this->get_sort_links($this->sort_config['sort_directions']);

        $this->result['sort_config'] = $this->sort_config;

        $this->result['shop_link'] = $this->diafan->_route->module($this->diafan->_site->module);
    }



    /**
     * Формирует SQL-запрос при поиске по товарам
     *
     * @return boolean true
     */
    private function where(&$where, &$where_param, &$values, &$getnav, &$group)
    {
        $where = ' AND s.site_id=%d';
        $values[] = $this->diafan->_site->id;
        $values_param = array();

        $getnav = '?action=search';
        if (!empty($_REQUEST["cat_id"]))
        {
            $this->diafan->_route->cat = (int) preg_replace("/\D/", '', $_REQUEST['cat_id']);
            $catarr = array(0);
            $getnav .='&cat_id='.$this->diafan->_route->cat;
            if ($this->diafan->_route->cat)
            {
                $children = $this->diafan->get_children($this->diafan->_route->cat, "shop_category");
                $children[] = $this->diafan->_route->cat;
                $where_param .= " INNER JOIN {shop_category_rel} AS c ON s.id=c.element_id AND c.cat_id IN (".implode(',', $children).")";
            }
        }

        if (!empty($_REQUEST["a"]) && $this->diafan->configmodules("search_article"))
        {
            $where .= " AND LOWER(REPLACE(REPLACE(s.article, ' ', ''), '-', ''))='%h'";
            $_REQUEST["a"] = $this->diafan->filter($_REQUEST, "string", "a");
            $values[] = str_replace(array(' ', '-'), '', $_REQUEST["a"]);
            $getnav .= '&a='.$_REQUEST["a"];
        }

        if (!empty($_REQUEST["brand"]) && $this->diafan->configmodules("search_brand"))
        {
            $brand = array();
            if(is_array($_REQUEST["brand"]))
            {
                foreach($_REQUEST["brand"] as $b)
                {
                    $b = $this->diafan->filter($b, "integer");
                    if($b)
                    {
                        $brand[] = $b;
                    }
                }
            }
            else
            {
                $b = $this->diafan->filter($_REQUEST, "integer", "brand");
                if($b)
                {
                    $brand[] = $b;
                }
            }
            if($brand)
            {
                $where .= " AND s.brand_id".(count($brand) == 1 ? '='.$brand[0] : ' IN ('.implode(',', $brand).')');
                $getnav .= '&brand[]='.implode('&brand[]=', $brand);
            }
        }

        if (!empty($_REQUEST["ac"]) && $this->diafan->configmodules("search_action"))
        {
            $where .= " AND s.action='1'";
            $getnav .= '&ac=1';
        }

        if (!empty($_REQUEST["hi"]) && $this->diafan->configmodules("search_hit"))
        {
            $where .= " AND s.hit='1'";
            $getnav .= '&hi=1';
        }

        if (!empty($_REQUEST["ne"]) && $this->diafan->configmodules("search_new"))
        {
            $where .= " AND s.new='1'";
            $getnav .= '&ne=1';
        }

        if (!empty($_REQUEST["pr1"]) || !empty($_REQUEST["pr2"]))
        {
            if (!empty($_REQUEST["pr1"]))
            {
                $pr1 = $this->diafan->filter($_REQUEST, "int", "pr1");
                $getnav .= '&pr1='.$pr1;
            }
            if (!empty($_REQUEST["pr2"]))
            {
                $pr2 = $this->diafan->filter($_REQUEST, "int", "pr2");
                $getnav .= '&pr2='.$pr2;
            }
            $where_param .= " INNER JOIN {shop_price} AS pr ON pr.good_id=s.id AND pr.trash='0'"
                ." AND pr.date_start<=".time()." AND (pr.date_start=0 OR pr.date_finish>=".time().")"
                ." AND pr.currency_id=0"
                ." AND pr.role_id".($this->diafan->_users->role_id ? " IN (0,".$this->diafan->_users->role_id.")" : "=0")
                ." AND (pr.person='0'".($this->person_discount_ids ? " OR pr.discount_id IN(".implode(",", $this->person_discount_ids).")" : "").")";
            $group = ", pr.price_id HAVING"
                .(!empty($_REQUEST["pr1"]) ? " MIN(ROUND(pr.price))>=".$pr1 : '')
                .(!empty($_REQUEST["pr2"]) ? (!empty($_REQUEST["pr1"]) ? " AND" : "")." MIN(pr.price)<=".$pr2 : '');
        }
        else
        {
            $where_param .= " LEFT JOIN {shop_price} AS pr ON pr.good_id=s.id AND pr.trash='0'"
                ." AND pr.date_start<=".time()." AND (pr.date_start=0 OR pr.date_finish>=".time().")"
                ." AND pr.currency_id=0"
                ." AND pr.role_id".($this->diafan->_users->role_id ? " IN (0,".$this->diafan->_users->role_id.")" : "=0")
                ." AND (pr.person='0'".($this->person_discount_ids ? " OR pr.discount_id IN(".implode(",", $this->person_discount_ids).")" : "").")";
        }
        $rows = DB::query_fetch_all("SELECT DISTINCT(p.id), p.type, p.required FROM {shop_param} as p "
            ." INNER JOIN {shop_param_category_rel} AS c ON p.id=c.element_id "
            .($this->diafan->configmodules("cat") ? " AND (c.cat_id=%d OR c.cat_id=0)" : "")
            ." WHERE p.search='1' AND p.trash='0' ORDER BY p.sort ASC", $this->diafan->_route->cat);
        foreach ($rows as $row)
        {
            if ($row["type"] == 'date' && (!empty($_REQUEST["p".$row["id"]."_1"]) || !empty($_REQUEST["p".$row["id"]."_2"])))
            {
                $where_param .= " INNER JOIN {shop_param_element} AS pe".$row["id"]." ON pe".$row["id"].".element_id=s.id AND pe".$row["id"].".param_id='%d'"
                    ." AND pe".$row["id"].".trash='0'";
                $values_param[] = $row["id"];
                if (!empty($_REQUEST["p".$row["id"]."_1"]))
                {
                    $where_param .= " AND pe".$row["id"].".value".$this->diafan->_languages->site.">='%s'";
                    $values_param[] = $this->diafan->formate_in_date($_REQUEST["p".$row["id"]."_1"]);
                    $getnav .= '&p'.$row["id"].'_1='.$this->diafan->filter($_REQUEST, "url", "p".$row["id"]."_1");
                }
                if (!empty($_REQUEST["p".$row["id"]."_2"]))
                {
                    $where_param .= " AND pe".$row["id"].".value".$this->diafan->_languages->site."<='%s'";
                    $values_param[] = $this->diafan->formate_in_date($_REQUEST["p".$row["id"]."_2"]);
                    $getnav .= '&p'.$row["id"].'_2='.$this->diafan->filter($_REQUEST, "url", "p".$row["id"]."_2");
                }
            }
            elseif ($row["type"] == 'datetime' && (!empty($_REQUEST["p".$row["id"]."_1"]) || !empty($_REQUEST["p".$row["id"]."_2"])))
            {
                $where_param .= " INNER JOIN {shop_param_element} AS pe".$row["id"]." ON pe".$row["id"].".element_id=s.id AND pe".$row["id"].".param_id='%d'"
                    ." AND pe".$row["id"].".trash='0'";
                $values_param[] = $row["id"];
                if (!empty($_REQUEST["p".$row["id"]."_1"]))
                {
                    $where_param .= " AND pe".$row["id"].".value".$this->diafan->_languages->site.">='%s'";
                    $values_param[] = $this->diafan->formate_in_datetime($_REQUEST["p".$row["id"]."_1"]);
                    $getnav .= '&p'.$row["id"].'_1='.$this->diafan->filter($_REQUEST, "url", "p".$row["id"]."_1");
                }
                if (!empty($_REQUEST["p".$row["id"]."_2"]))
                {
                    $where_param .= " AND pe".$row["id"].".value".$this->diafan->_languages->site."<='%s'";
                    $values_param[] = $this->diafan->formate_in_datetime($_REQUEST["p".$row["id"]."_2"]);
                    $getnav .= '&p'.$row["id"].'_2='.$this->diafan->filter($_REQUEST, "url", "p".$row["id"]."_2");
                }
            }
            elseif ($row["type"] == 'numtext' && (!empty($_REQUEST["p".$row["id"]."_2"]) || !empty($_REQUEST["p".$row["id"]."_1"])))
            {
                $val1 = $this->diafan->filter($_REQUEST, "float", "p".$row["id"]."_1");
                $val2 = $this->diafan->filter($_REQUEST, "float", "p".$row["id"]."_2");
                $where_param .= " INNER JOIN {shop_param_element} AS pe".$row["id"]." ON pe".$row["id"].".element_id=s.id AND pe".$row["id"].".param_id='%d'"
                    ." AND pe".$row["id"].".trash='0'"
                    .($val1 ? " AND pe".$row["id"].".value".$this->diafan->_languages->site.">=%f" : '')
                    .($val2 ? " AND pe".$row["id"].".value".$this->diafan->_languages->site."<=%f" : '')
                ;
                $values_param[] = $row["id"];
                if ($val1)
                {
                    $values_param[] = $val1;
                    $getnav .= '&p'.$row["id"].'_1='.$val1;
                }
                if ($val2)
                {
                    $values_param[] = $val2;
                    $getnav .= '&p'.$row["id"].'_2='.$val2;
                }
            }
            elseif ($row["type"] == 'checkbox' && !empty($_REQUEST["p".$row["id"]]))
            {
                $where_param .= " INNER JOIN {shop_param_element} AS pe".$row["id"]." ON pe".$row["id"].".element_id=s.id AND pe".$row["id"].".param_id='%d'"
                    ." AND pe".$row["id"].".trash='0' AND pe".$row["id"].".value".$this->diafan->_languages->site."='1'";
                $values_param[] = $row["id"];
                $getnav .= '&p'.$row["id"].'=1';
            }
            elseif (($row["type"] == 'select' || $row["type"] == 'multiple') && !empty($_REQUEST["p".$row["id"]]))
            {
                if (!is_array($_REQUEST["p".$row["id"]]))
                {
                    $val = $this->diafan->filter($_REQUEST, "int", "p".$row["id"]);
                    $getnav .= '&p'.$row["id"].'='.$val;
                    $vals = array($val);
                }
                else
                {
                    $vals = array();
                    foreach ($_REQUEST["p".$row["id"]] as $val)
                    {
                        if ($val)
                        {
                            $val = intval($val);
                            $vals[] = $val;
                            $getnav .= '&p'.$row["id"].'[]='.$val;
                        }
                    }
                }
                if (!empty($vals))
                {
                    if ($row["required"])
                    {
                        $where_param .= " INNER JOIN {shop_price_param} AS prp".$row["id"]." ON prp".$row["id"].".price_id=pr.price_id";
                        $where .= " AND prp".$row["id"].".param_id=".$row["id"]." AND prp".$row["id"].".param_value IN (".implode(", ", $vals).",0) AND pe".$row["id"].".param_id=".$row["id"];
                        if(empty($first_required_param))
                        {
                            $first_required_param = " AND prp".$row["id"].".price_id=";
                        }
                        else
                        {
                            $where .= $first_required_param."prp".$row["id"].".price_id";
                        }
                    }
                    $where_param .= " ".($row["required"] ? "LEFT" : "INNER")." JOIN {shop_param_element} AS pe".$row["id"]." ON pe".$row["id"].".element_id=s.id AND pe".$row["id"].".param_id='%d'"
                        ." AND pe".$row["id"].".trash='0' AND pe".$row["id"].".value".$this->diafan->_languages->site." IN (".implode(", ", $vals).")";
                    $values_param[] = $row["id"];
                }
            }
        }

        $values = array_merge($values_param, $values);
    }


    /**
     * Получает из базы данных общее количество найденных при помощи поиска элементов
     *
     * @param string $where_param
     * @param string $where
     * @param string $group
     * @param array $values
     * @return integer
     */
    private function list_search_query_count($where_param, $where, $group, $values)
    {

        $result = DB::query("SELECT ".($group ? "DISTINCT s.id" : "COUNT(DISTINCT s.id)")." FROM {shop} AS s"
            .($this->diafan->configmodules('where_access_element') ? " LEFT JOIN {access} AS a ON a.element_id=s.id AND a.module_name='shop' AND a.element_type='element'" : "")
            .$where_param
            .($this->sort_config['use_params_for_sort'] ? " LEFT JOIN {shop_param_element} AS sp  ON sp.element_id=s.id AND sp.trash='0' AND sp.param_id=".$this->sort_config['param_ids'][$this->diafan->_route->sort] : '')
            ." WHERE s.[act]='1' AND s.trash='0'"
            .($this->diafan->configmodules('where_access_element') ? " AND (s.access='0' OR s.access='1' AND a.role_id=".$this->diafan->_users->role_id.")" : '')
            .$where
            .($group ? " GROUP BY s.id".$group : ''),
            $values);
        if($group)
        {
            $count = DB::num_rows($result);
            DB::free_result($result);
        }
        else
        {
            $count = DB::result($result);
        }
        return $count;
    }



    /**
     * Возвращает результаты, сформированные в моделе
     *
     * @return void
     */
    public function result()
    {
        $this->result["cart_link"] = $this->diafan->_route->module("cart");
        $this->result["wishlist_link"] = $this->diafan->_route->module("wishlist");
        $this->result["access_buy"] =  (! $this->diafan->configmodules('security_user', "shop") || $this->diafan->_users->id) ? false : true;
        if(! isset($this->result["hide_compare"]))
        {
            $this->result["hide_compare"] = $this->diafan->configmodules('hide_compare', "shop");
        }
        $this->result["buy_empty_price"] = $this->diafan->configmodules('buy_empty_price', "shop");
        if(! empty($this->result["depends_param"]))
        {
            foreach ($this->result["depends_param"] as &$param)
            {
                foreach ($param["values"] as &$value)
                {
                    if(! empty($_REQUEST["p".$param["id"]]))
                    {
                        if(is_array($_REQUEST["p".$param["id"]]))
                        {
                            if(in_array($value["id"], $_REQUEST["p".$param["id"]]))
                            {
                                $value["selected"] =  true;
                                break;
                            }
                        }
                        else
                        {
                            if($_REQUEST["p".$param["id"]] == $value["id"])
                            {
                                $value["selected"] =  true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        if($this->diafan->configmodules("one_click", "shop"))
        {
            Custom::inc('modules/cart/cart.model.php');
            $cart = new Cart_model($this->diafan);
            $this->result["one_click"] = $cart->one_click();
            $this->result["one_click"]["use"] = true;
        }
    }


    /**
     * Получает из базы данных найденных при помощи поиска элементы на одной странице
     *
     * @param string $where_param
     * @param string $where
     * @param string $group
     * @param array $values
     * @return array
     */
    private function list_search_query($where_param, $where, $group, $values)
    {
        switch($this->diafan->configmodules("sort"))
        {
            case 1:
                $order = 's.id DESC';
                break;
            case 2:
                $order = 's.id ASC';
                break;
            case 3:
                $order = 's.name'._LANG.' ASC';
                break;
            default:
                $order = 's.sort DESC, s.id DESC';
        }
        $rows = DB::query_range_fetch_all("SELECT DISTINCT s.id, s.[name], s.timeedit, s.[anons], s.site_id, s.brand_id, s.no_buy, s.article,"
            ."s.hit, s.new, s.action, s.is_file FROM {shop} AS s"
            .($this->diafan->configmodules('where_access_element') ? " LEFT JOIN {access} AS a ON a.element_id=s.id AND a.module_name='shop' AND a.element_type='element'" : "")
            .$where_param
            .($this->sort_config['use_params_for_sort'] ? " LEFT JOIN {shop_param_element} AS sp  ON sp.element_id=s.id AND sp.trash='0' AND sp.param_id=".$this->sort_config['param_ids'][$this->diafan->_route->sort] : '')
            ." WHERE s.[act]='1' AND s.trash='0'"
            .($this->diafan->configmodules('where_access_element') ? " AND (s.access='0' OR s.access='1' AND a.role_id=".$this->diafan->_users->role_id.")" : '')
            .$where
            ." GROUP BY s.id".$group
            ." ORDER BY ".($this->diafan->_route->sort ? $this->sort_config['sort_directions'][$this->diafan->_route->sort].',' : '')
            ." s.no_buy ASC, ".$order, $values, $this->diafan->_paginator->polog, $this->diafan->_paginator->nastr);
        return $rows;
    }


    /**
     * Форматирует данные о товаре для списка товаров
     *
     * @param array $rows все полученные из базы данных элементы
     * @param string $function функция, для которой генерируется список товаров
     * @param string $images_config настройки отображения изображений
     * @return void
     */
    public function elements(&$rows, $function = 'list', $images_config = '')
    {
        if (empty($this->result["timeedit"]))
        {
            $this->result["timeedit"] = '';
        }
        foreach ($rows as &$row)
        {
            $this->diafan->_shop->price_prepare_all($row["id"]);
        }
        foreach ($rows as &$row)
        {
            $this->price($row);
            if ($this->diafan->configmodules("images_element", "shop", $row["site_id"]))
            {
                if (is_array($images_config))
                {
                    if($images_config["count"] > 0)
                    {
                        $this->diafan->_images->prepare($row["id"], "shop");
                    }
                }
                elseif($this->diafan->configmodules("list_img_element", "shop", $row["site_id"]))
                {
                    if($this->diafan->configmodules("list_img_element", "shop", $row["site_id"]) == 1)
                    {
                        $image_ids = array();
                        foreach ($row["price_arr"] as $price)
                        {
                            if(! empty($price["image_rel"]))
                            {
                                $image_ids[] = $price["image_rel"];
                            }
                        }
                        if(! $image_ids)
                        {
                            $this->diafan->_images->prepare($row["id"], "shop");
                        }
                    }
                    else
                    {
                        $this->diafan->_images->prepare($row["id"], "shop");
                    }
                }
            }
            if($row["brand_id"] && ! isset($this->cache["prepare_brand"][$row["brand_id"]]) && ! isset($this->cache["brand"][$row["brand_id"]]))
            {
                $this->cache["prepare_brand"][$row["brand_id"]] = true;
            }
            $this->diafan->_route->prepare($row["site_id"], $row["id"], "shop");

            $this->prepare_param($row["id"], $row["site_id"], $function);
            $ids[] = $row["id"];
        }
        if(isset($this->cache["prepare_brand"]))
        {
            $brands = DB::query_fetch_all("SELECT id, [name], site_id FROM {shop_brand} WHERE trash='0' AND [act]='1' AND id IN (%s)", implode(",", array_keys($this->cache["prepare_brand"])));
            foreach($brands as $b)
            {
                $this->diafan->_route->prepare($b["site_id"], $b["id"], "shop", "brand");
            }
            foreach($brands as $b)
            {
                $b["link"] = $this->diafan->_route->link($b["site_id"], $b["id"], "shop", "brand");
                $this->cache["brand"][$b["id"]] = $b;
            }
        }
        if($rows)
        {
            $additional_cost_rels = DB::query_fetch_key_array("SELECT a.id, a.[name], a.percent, a.price, r.element_id, r.summ FROM {shop_additional_cost} AS a INNER JOIN {shop_additional_cost_rel} AS r ON r.additional_cost_id=a.id WHERE r.element_id IN (%s) AND a.trash='0'", implode(",", $ids), "element_id");
        }
        foreach ($rows as &$row)
        {
            if ( ! $this->diafan->configmodules("cat", "shop", $row["site_id"]))
            {
                $row["cat_id"] = 0;
            }
            if ($row["timeedit"] < $this->result["timeedit"])
            {
                $this->result["timeedit"] = $row["timeedit"];
            }
            unset($row["timeedit"]);

            if($row["brand_id"] && ! empty($this->cache["brand"][$row["brand_id"]]))
            {
                $row["brand"] = $this->cache["brand"][$row["brand_id"]];
            }
            else
            {
                $row["brand"] = false;
            }

            $row["additional_cost"] = array();
            if(! empty($additional_cost_rels[$row["id"]]))
            {
                foreach($additional_cost_rels[$row["id"]] AS $a_c_rel)
                {
                    if($a_c_rel["percent"])
                    {
                        foreach($row["price_arr"] as $price)
                        {
                            $a_c_rel["price_summ"][$price["price_id"]] = ($price["price"] * $a_c_rel["percent"]) / 100;
                            $a_c_rel["format_price_summ"][$price["price_id"]] = $this->diafan->_shop->price_format($a_c_rel["price_summ"][$price["price_id"]]);
                        }
                    }
                    else
                    {
                        if(! $a_c_rel["summ"])
                        {
                            $a_c_rel["summ"] = $a_c_rel["price"];
                        }
                        if($a_c_rel["summ"])
                        {
                            $a_c_rel["format_summ"] = $this->diafan->_shop->price_format($a_c_rel["summ"]);
                        }
                    }
                    $row["additional_cost"][] = $a_c_rel;
                }
            }

            $row["link"] = $this->diafan->_route->link($row["site_id"], $row["id"], "shop");

            if ($this->diafan->configmodules("images_element", "shop", $row["site_id"]))
            {
                $count = 0;
                if (is_array($images_config))
                {
                    $count = $images_config["count"];
                    $link = $row["link"];
                    if($images_config["count"] > 0)
                    {
                        $row["img"]  = $this->diafan->_images->get(
                            $images_config["variation"], $row["id"], 'shop', 'element',
                            $row["site_id"], $row["name"], 0,
                            $images_config["count"],
                            $row["link"]
                        );
                        $tag = $images_config["variation"];
                    }
                }
                elseif($this->diafan->configmodules("list_img_element", "shop", $row["site_id"]))
                {
                    $count = $this->diafan->configmodules("list_img_element", "shop", $row["site_id"]) == 1 ? 1 : 'all';
                    $tag = 'medium';
                    $link = ($count !== 'all' ? $row["link"] : 'large');
                }
                if($count && $count != 'all')
                {
                    $image_ids = array();
                    foreach ($row["price_arr"] as $price)
                    {
                        if(! empty($price["image_rel"]))
                        {
                            $image_ids[] = $price["image_rel"];
                        }
                    }
                    if($image_ids)
                    {
                        $count = $image_ids;
                    }
                }
                if($count)
                {
                    $row["img"]  = $this->diafan->_images->get(
                        $tag, $row["id"], 'shop', 'element',
                        $row["site_id"], $row["name"], 0,
                        $count == "all" ? 0 : $count,
                        $link
                    );
                }
            }

            $this->param($row, $function);
            $row["is_file"] = $this->diafan->configmodules("use_non_material_goods", "shop") ? $row["is_file"] : 0;
        }
        if(! isset($this->result["currency"]))
        {
            $this->result["currency"] = $this->diafan->configmodules("currency", "shop");
        }
    }

}