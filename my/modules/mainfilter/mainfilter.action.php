<?php
/**
 * Обработка запроса
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

class Mainfilter_action extends Action
{

    public function get() {
        $this->diafan->_site->id = 9;
        $this->diafan->_paginator->nastr = 999;

        Custom::inc('modules/shop/shop.model.php');
        $shop = new Shop_model($this->diafan);
        $shop->list_search();
        $shop->result();
        $shop->result["ajax"] = true;
        $this->result["data"] = $this->diafan->_tpl->get('list_search_main', 'shop', $shop->result);
        $this->result["result"] = 'success';
        //$this->result["js"] = '<script src="'.BASE_PATH.File::compress(Custom::path('modules/shop/js/shop.buy_form.js'), 'js').'" type="text/javascript" charset="UTF-8"></script>';
    }

}