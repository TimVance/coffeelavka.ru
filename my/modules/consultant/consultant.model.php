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

class Consultant_model extends Model
{
	/**
	 * Генерирует данные для шаблонной функции: on-line консультант
	 * @return string
	 */
	public function show_block($system)
	{
		switch($system)
		{
			case 'redhelper':
				return $this->redhelper();

			case 'jivosite':
				return $this->jivosite();

			case 'livetex':
				return $this->livetex();
		}
	}

	/**
	 * Генерирует данные для шаблонной функции: on-line консультант системы RedHelper
	 * @return string
	 */
	private function redhelper()
	{
		if(! $this->diafan->configmodules("redhelper_login", "consultant"))
		{
			return '';
		}
		$result = '
<!-- RedHelper -->
<link href="'.BASE_PATH.'modules/consultant/consultant.css" rel="stylesheet" type="text/css">';
$place = $this->diafan->configmodules("redhelper_place", "consultant");
if(! in_array($place, array('top', 'left', 'right')))
{
	$place = 'left';
}
if($this->diafan->configmodules("redhelper_small", "consultant"))
{
	$place .= '_small';
}
if($this->diafan->configmodules("redhelper_color", "consultant"))
{
	$result .= '<style type="text/css">
	.redhlp_button_diafan_'.$place.' span
	{
	background-color:'.$this->diafan->configmodules("redhelper_color", "consultant").' !important;
	}
	</style>';
}
$result  .= '<div class="redhlp_button_diafan_'.$place.' redhlp_button"><span class="offline"></span><span class="online"></span></div>
<script id="rhlpscrtg" type="text/javascript" charset="utf-8" async="async" 
	src="https://web.redhelper.ru/service/main.js?c='.$this->diafan->configmodules("redhelper_login", "consultant").'">
</script>
<script>
redhlpSettings = {';
if($this->diafan->configmodules("redhelper_chatX", "consultant"))
{
	$result .= "\n".'chatX: "'.str_replace(array('"', "\n"), '', $this->diafan->configmodules("redhelper_chatX", "consultant")).'",'."\n";
}
if($this->diafan->configmodules("redhelper_chatY", "consultant"))
{
	$result .= "\n".'chatY: "'.str_replace(array('"', "\n"), '', $this->diafan->configmodules("redhelper_chatY", "consultant")).'",'."\n";
}
if($this->diafan->configmodules("redhelper_header", "consultant"))
{
	$result .= "\n".'header: "'.str_replace(array('"', "\n"), '', $this->diafan->configmodules("redhelper_header", "consultant")).'",'."\n";
}
if($this->diafan->configmodules("redhelper_topText", "consultant"))
{
	$result .= "\n".'topText: "'.str_replace(array('"', "\n"), '', $this->diafan->configmodules("redhelper_topText", "consultant")).'",'."\n";
}
if($this->diafan->configmodules("redhelper_welcome", "consultant"))
{
	$result .= "\n".'welcome: "'.str_replace(array('"', "\n"), '', $this->diafan->configmodules("redhelper_welcome", "consultant")).'",'."\n";
}
if($this->diafan->configmodules("redhelper_inviteTime", "consultant"))
{
	$result .= "\n".'inviteTime: '.intval($this->diafan->configmodules("redhelper_inviteTime", "consultant")).','."\n";
}
if($this->diafan->configmodules("redhelper_chatWidth", "consultant"))
{
	$result .= "\n".'chatWidth: '.intval($this->diafan->configmodules("redhelper_chatWidth", "consultant")).','."\n";
}
if($this->diafan->configmodules("redhelper_chatHeight", "consultant"))
{
	$result .= "\n".'chatHeight: '.intval($this->diafan->configmodules("redhelper_chatHeight", "consultant")).','."\n";
}

	//$result .= "\n".'hideBadge: true,'."\n";
	$result .= '
}

</script>
<!--/Redhelper -->';
		return $result;
	}

	/**
	 * Генерирует данные для шаблонной функции: on-line консультант системы LiveTex
	 * @return string
	 */
	private function livetex()
	{
		if(! $this->diafan->configmodules("livetex_id", "consultant"))
		{
			return '';
		}
		$result = '<script type=\'text/javascript\'> /* build:::7 */
			var liveTex = true,
				liveTexID = '.$this->diafan->configmodules("livetex_id", "consultant").',
				liveTex_object = true;
			(function() {
				var lt = document.createElement(\'script\');
				lt.type =\'text/javascript\';
				lt.async = true;
				lt.src = \'http://cs15.livetex.ru/js/client.js\';
				var sc = document.getElementsByTagName(\'script\')[0];
				if ( sc ) sc.parentNode.insertBefore(lt, sc);
				else  document.documentElement.firstChild.appendChild(lt);
			})();
		</script>';
		return $result;
	}

	/**
	 * Генерирует данные для шаблонной функции: on-line консультант системы JivoSite
	 * @return string
	 */
	private function jivosite()
	{
		if($this->diafan->configmodules("jivosite_id", "consultant"))
		{
			$result = "<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = '".$this->diafan->configmodules("jivosite_id", "consultant")."';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->";
		}
		else
		{
			$result = '<!-- BEGIN JIVOSITE CODE {literal} -->
<link rel="stylesheet" href="//cdn.jivosite.com/css/label.css">
<a href="http://www.jivosite.ru?partner_id=1936&lang=ru&pricelist_id=5&utm_source=diafan.ru&utm_medium=link&utm_content=offline_form&utm_campaign=diafan" target="_blank"><div id="jivo_top_wrap" title="Зарегистрируйтесь на сайте JivoSite и активируйте консультант в административной части сайта"><div id="jivo_chat_widget"><div id="jivo_chat_widget_online">
<div id="jivo-label" class="jivo-fixed-bottom jivo-animate jivo-online" style="right: 30px; height: 33px; visibility: visible; display: block; width: 344px; z-index: 100;">
<div class="jivo-triangle-wraper jivo_shadow jivo_rounded_corners jivo_gradient jivo_3d_effect jivo_border">
<div class="jivo-triangle-clip">
<div class="jivo-triangle jivo-label-triangle" style="border-left-color: rgb(105, 106, 134);"><div class="jivo-triangle-inner" style="background-color: rgb(105, 106, 134);"></div></div>
<div class="jivo-noise jivo-noise-pattern-light"></div>
<div class="jivo-css-leaf jivo-online jivo-light">
<div class="jivo-top-right-square">
<div class="jivo-bottom-left-square"></div>
</div>
</div>
</div>
</div>
<div id="jivo-label-wrapper" style="height: 33px">
<div id="jivo-label-status" class="jivo-light"></div>
<div id="jivo-label-text" class="jivo-ru_RU" style="font-size: 13px; font-family: Arial; color: rgb(240, 241, 241); font-weight: bold; font-style: normal; background-color: #696A86;">Напишите нам, мы онлайн!</div>
<div id="jivo-label-indicator"></div>
<div id="jivo-label-copyright" class="jivo-light jivo-ru_RU"></div>
</div>
</div>
</div></div></div></a>
<!-- {/literal} END JIVOSITE CODE -->';
		}
		return $result;
	}
}