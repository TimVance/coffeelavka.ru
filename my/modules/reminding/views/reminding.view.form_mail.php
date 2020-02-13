<?php
/**
 * Шаблон формы восстановления доступа
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

echo '<div class="row"><div class="col-md-6">
<form method="POST" action="" class="reminding_form ajax">
<input type="hidden" name="action" value="mail">
<input type="hidden" name="module" value="reminding">
'.$result["action"].'

<div class="form-group">
	<label>'.$this->diafan->_('Введите ваш e-mail').'<span style="color:red;">*</span>:</label>
<input type="email" class="form-control" name="mail" value="">
<div class="errors text-danger error_mail"'.($result["error_mail"] ? '>'.$result["error_mail"] : ' style="display:none">').'</div></div>

'.$result["captcha"].'

<input type="submit" class="btn btn-warning" value="'.$this->diafan->_('Отправить', false).'">

<div class="required_field"><span style="color:red;">*</span> — '.$this->diafan->_('Поля, обязательные для заполнения').'</div>

</form>

<div class="errors error  reminding_result"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div></div></div>';