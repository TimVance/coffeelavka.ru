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

class Messages_model extends Model
{
    /**
     * Генерирует список
     *
     * @return array
     */
    public function list_()
    {
		$this->diafan->_paginator->nen = DB::query_result("SELECT COUNT(id) FROM {messages_user} WHERE user_id=%d", $this->diafan->_users->id);

		if (! $this->diafan->_paginator->nen)
		{
			return $this->result;
		}

		$this->result["paginator"] = $this->diafan->_paginator->get();

		$this->result["rows"] = DB::query_range_fetch_all("SELECT m.id, m.contact_user_id, m.date_update, m.readed, m.count_message AS m FROM {messages_user} AS m INNER JOIN {users} AS u ON u.id=m.contact_user_id AND u.act='1' AND u.trash='0' WHERE m.user_id=%d ORDER BY m.date_update DESC", $this->diafan->_users->id, $this->diafan->_paginator->polog, $this->diafan->_paginator->nastr);
		foreach ($this->result["rows"] as &$row)
		{
			$this->prepare_author($row["contact_user_id"]);
			$this->diafan->_route->prepare($this->diafan->_site->id, $row["contact_user_id"], "messages");
		}
		foreach ($this->result["rows"] as &$row)
		{
			$row['user'] = $this->get_author($row['contact_user_id']);
			$row['date_update'] = $this->format_date($row['date_update']);
			$row['last_message'] = DB::query_fetch_array("SELECT text, created FROM {messages} WHERE author=%d AND to_user=%d OR author=%d AND to_user=%d ORDER BY created DESC LIMIT 1", $this->diafan->_users->id, $row["contact_user_id"], $row["contact_user_id"], $this->diafan->_users->id);
			$row['last_message']['created'] = $this->format_date($row['last_message']['created']);
			$row['link'] = BASE_PATH_HREF.$this->diafan->_route->link($this->diafan->_site->id, $row["contact_user_id"], "messages");
		}

		$this->result["view"] = 'list';
    }

    /**
     * Генерирует данные для страницы переписки с пользователем
     *
     * @return void
     */
    public function id()
    {
		$this->prepare_author($this->diafan->_route->show);
		$this->prepare_author($this->diafan->_users->id);

		$this->diafan->_site->breadcrumb[] = array('name' => $this->diafan->_site->name, 'link' => $this->diafan->_route->current_link("show"));
		$this->result['user'] = $this->get_author($this->diafan->_route->show);
		$this->diafan->_site->titlemodule = $this->diafan->_('Переписка с пользователем', false).' '.$this->result['user']["fio"].' ('.$this->result['user']["name"].')';
		$this->result["title"] = $this->diafan->_site->titlemodule;

		////navigation//
		$this->diafan->_paginator->nen = DB::query_result("SELECT COUNT(id) FROM {messages} WHERE author=%d AND to_user=%d OR author=%d AND to_user=%d", $this->diafan->_users->id, $this->diafan->_route->show, $this->diafan->_route->show, $this->diafan->_users->id);
		$this->result["paginator"] = $this->diafan->_paginator->get();
		////navigation///

		if (! $this->diafan->_paginator->nen && $this->diafan->_route->page)
		{
			Custom::inc('includes/404.php');
		}

		$update_readed = array();
		$this->result["rows"] = DB::query_range_fetch_all("SELECT id,author,created,text,readed FROM {messages} WHERE author=%d AND to_user=%d OR author=%d AND to_user=%d ORDER BY created DESC", $this->diafan->_users->id,$this->diafan->_route->show, $this->diafan->_route->show, $this->diafan->_users->id, $this->diafan->_paginator->polog, $this->diafan->_paginator->nastr);
		foreach ($this->result["rows"] as &$row)
		{
			if ($row["author"] != $this->diafan->_users->id && !$row["readed"])
			{
				$update_readed[] = $row["id"];
			}
			else
			{
				$row["readed"] = 1;
			}

			$row['created'] = $this->format_date($row['created']);
			$row['name'] = $this->get_author($row['author']);
		}

		if (!empty($update_readed))
		{
			DB::query("UPDATE {messages} SET readed='1' WHERE id IN (%s)", implode(',', $update_readed));
		}

		if(! DB::query_result("SELECT id FROM {messages} WHERE readed='0' AND author=%d AND to_user=%d LIMIT 1",$this->diafan->_route->show, $this->diafan->_users->id))
		{
			DB::query("UPDATE {messages_user} SET readed='1' WHERE user_id=%d AND contact_user_id=%d", $this->diafan->_users->id, $this->diafan->_route->show);
		}

		$this->result["view"] = 'id';
    }
}
