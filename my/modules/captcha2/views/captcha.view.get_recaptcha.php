<?php
/**
 * Шаблон reCAPTCHA
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

echo '<div class="js_captcha captcha">
	<div id="recaptcha_div_'.$result["modules"].'"></div>
	<div class="js_recaptcha_show recaptcha_show"><a href="javascript:void(0)" onclick="create_recaptcha(\'recaptcha_div_'.$result["modules"].'\');">'.$this->diafan->_('Показать капчу').'</a></div>
	<div class="errors error_captcha"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>
</div>';

echo '<script type="text/javascript">
var recaptcha_public_key = "'.$this->diafan->configmodules('recaptcha_public_key', 'captcha').'";
</script>';