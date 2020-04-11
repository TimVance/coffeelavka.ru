<?php
/**
 * Установка модуля
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


class Mainfilter_install extends Install
{
    /**
     * @var string название
     */
    public $title = "Фильтр на главной";

    public $modules = array(
        array(
            "name" => "mainfilter",
            "admin" => false,
            "site" => true,
            "site_page" => true,
        ),
    );

}