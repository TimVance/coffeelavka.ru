<?php
/**
 * Контроллер
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

if (!defined('DIAFAN')) {
    $path = __FILE__;
    $i    = 0;
    while (!file_exists($path . '/includes/404.php')) {
        if ($i == 10) exit;
        $i++;
        $path = dirname($path);
    }
    include $path . '/includes/404.php';
}

class Mainfilter extends Controller
{

    public function action()
    {
        if(! empty($_POST["action"]))
        {
            switch($_POST["action"])
            {
                case 'get':
                    return $this->action->get();

            }
        }
    }

    public function show_block()
    {

        $result = $this->model->show_block();
        echo $this->diafan->_tpl->get('show_block', 'mainfilter', $result, array());

    }

}