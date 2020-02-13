<?php
/**
 * Подключение для работы с постраничной навигацией
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

/**
 * Paginator_inc
 */
class Paginator_inc extends Diafan
{
	/**
	 * @var integer количество элементов, показанных на странице
	 */
	public $nastr = 0;

	/**
	 * @var strign название переменной, содержащей номер страницы
	 */
	public $variable = 'page';

	/**
	 * @var integer количество ссылок постраничной навигации, показанных на одной страние
	 */
	public $navnastr = 10;

	/**
	 * @var string ссылка на первую страницу
	 */
	public $navlink;

	/**
	 * @var integer номер страницы
	 */
	public $page;

	/**
	 * @var string GET переменные, участвующие в навигации для постраничного вывода
	 */
	public $get_nav;

	/**
	 * @var string шаблон части ссылки, отвечающей  за передачу номера страницы 
	 */
	public $urlpage = 'page%d/';

	/**
	 * @var integer порядковый номер элемента, с которого начинается вывод элементов
	 */
	public $polog = 0;

	/**
	 * @var integer количество элементов в списке
	 */
	public $nen;

	/**
	 * @var string шаблон ссылки второй и последующих страниц, если не задан используется navlink + urlpage
	 */
	private $navlink_tpl;

	/**
	 * Формирует строку навигации
	 * 
	 * @return array
	 */
	public function get()
	{
		$this->config();
		$links    = array();
		$rout_end =  ROUTE_END;
		$navlink  = $this->navlink;
		if(! IS_ADMIN && ROUTE_END != '/')
		{
			$navlink = preg_replace('/'.preg_quote($rout_end, '/').'$/', '', $navlink);
			if($this->urlpage == 'page%d/')
			{
				$this->urlpage = '/page%d'.ROUTE_END;
			}
		}
        
		$string    = '';
		if ($this->nen > $this->nastr)
		{
			if($this->page != 1)
			{
				$links[] = array(
					"type" => "first",
					"link" => $this->navlink.$this->get_nav
					);
			}
			$nen = ceil($this->nen / $this->nastr);
			$apage = 1;
			$bpage = $this->navnastr;
			while ($this->page > $bpage && $apage < $nen)
			{
				$apage += $this->navnastr;
				$bpage += $this->navnastr;
			}
			if ($bpage > $nen)
			{
				$bpage = $nen;
			}
			if ($nen > $this->navnastr && $apage != 1)
			{
				if ($this->navlink_tpl)
				{
					$url = sprintf($this->navlink_tpl, $apage - 1);
				}
				else
				{
					$url = $navlink.sprintf($this->urlpage, $apage - 1);
				}
				$links[] = array(
						 "type" => "previous",
						 "link" => ($apage < 3 ? $this->navlink : $url).$this->get_nav
						);
			}
			for ($i = $apage; $i <= $bpage; $i++)
			{
				if ($this->page == $i)
				{
					$links[] = array(
							 "type" => "current",
							 "name" => $i
							);
				}
				else
				{
					if ($this->navlink_tpl)
					{
						$url = sprintf($this->navlink_tpl, $i);
					}
					else
					{
						$url = $navlink.sprintf($this->urlpage, $i);
					}
					$links[] = array(
							 "type" => "default",
							 "name" => $i,
							 "link" => ($i == 1 ? $this->navlink : $url).$this->get_nav
							);
				}
			}
			if ($nen > $this->navnastr && $bpage != $nen)
			{
				if ($this->navlink_tpl)
				{
					$url = sprintf($this->navlink_tpl, $apage + $this->navnastr);
				}
				else
				{
					$url = $navlink.sprintf($this->urlpage, $apage + $this->navnastr);
				}
				$links[] = array(
						 "type" => "next",
						 "nen"  => $nen,
						 "link" => $url.$this->get_nav
						);
			}
			if($nen != $this->page)
			{
				$links[] = array(
							"type" => "last",
							"link" => $navlink.sprintf($this->urlpage, $nen).$this->get_nav
							);			
			}
		}

		return $links;
	}

	/**
	 * Рассчитывает параметры постраничной навигации
	 * 
	 * @return void
	 */
	private function config()
	{
		if (! IS_ADMIN)
		{
			if($this->variable == 'page')
			{
				$this->page = $this->diafan->_route->page;
				$this->navlink = $this->diafan->_route->current_link(array("page", "dpage"));
				$this->navlink_tpl = $this->diafan->_route->current_link("dpage", array("page" => "%d"));
				if(! $this->nastr && $this->diafan->configmodules("nastr"))
				{
					$this->nastr = $this->diafan->configmodules("nastr");
				}
			}
			else
			{
				$v = $this->variable; 
				$this->page     = $this->diafan->_route->$v;
				$this->navlink  = $this->diafan->_route->current_link($v);
				$this->navlink_tpl = $this->diafan->_route->current_link("", array($v => "%d"));
				$this->urlpage = '/'.$v.'%d'.ROUTE_END;
			}
		}
		else
		{
			if($this->urlpage == 'page%d/')
			{
				$this->diafan->_paginator->page    = $this->diafan->_route->page;
			}
			if ($this->diafan->_users->admin_nastr)
			{
				$this->diafan->_paginator->nastr = $this->diafan->_users->admin_nastr;
			}
			else
			{
				$this->diafan->_paginator->nastr = $this->diafan->nastr;
			}
		}

		if ($this->page)
		{
			$this->polog = ($this->page - 1) * $this->nastr;
			if (($this->page - 1) * $this->nastr >= $this->nen)
			{
				if(IS_ADMIN)
				{
					if(preg_match('/rewrite=index\.php\/(.*)&rewrite=(.*)/', getenv('QUERY_STRING'), $m))
					{
						$query = $m[1];
					}
					else
					{
						$query = getenv('QUERY_STRING');
					}
					$query = str_replace(array('page'.$this->page, 'rewrite=index.php/'), array('page1', ''), $query);
				}
				else
				{
					if($this->variable == 'rpage')
					{
						ob_end_clean();
						ob_end_clean();
						ob_end_clean();
					}
					Custom::inc('includes/404.php');
				}
			}
		}
		else
		{
			$this->page  = 1;
			$this->polog = 0;
		}
		if (! $this->nastr)
		{
			$this->nastr = 10;
		}
	}
}