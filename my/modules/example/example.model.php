<?php
/**
 * Модель
 * 
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://cms.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2014 OOO «Диафан» (http://diafan.ru)
 */

if (! defined('DIAFAN'))
{
	include dirname(dirname(dirname(__FILE__))).'/includes/404.php';
}

/**
 * Example_model
 */
class Example_model extends Model
{
	/**
	 * @return void
	 */
 public function show()
{

        $this->result = array();

        ////navigation//
        //$this->diafan->_paginator->nen = DB::query_result("SELECT * FROM {example}");
        $this->result["paginator"] = $this->diafan->_paginator->get();
        ////navigation///

        $rows = DB::query_range_fetch_all("SELECT * FROM {example}",
            $this->diafan->_paginator->polog, $this->diafan->_paginator->nastr);

        foreach($rows as $row)
        {
            $row['created'] = $this->format_date($row['created'], 'example');
            $row['link'] = $this->diafan->_route->link($this->diafan->_site->id, $row["id"], 'example');

            $this->result['rows'][] = $row;
        }
////////////////////////////
        $rows333 = DB::query_range_fetch_all("SELECT name1 FROM {payment} WHERE id=1",
            $this->diafan->_paginator->polog, $this->diafan->_paginator->nastr);

        foreach($rows333 as $row555)
        {
            $row555['created'] = $this->format_date($row555['created'], 'example');
            $row555['link'] = $this->diafan->_route->link($this->diafan->_site->id, $row555["id"], 'example');

            $this->result['rows333'][] = $row555;
        }
///////////////////////////
    //$this->result["paginator"] = $this->diafan->_tpl->get('get', 'paginator', $this->result["paginator"]);
    $this->result['view'] = 'show';
}
}