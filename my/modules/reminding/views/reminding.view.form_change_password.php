<?php
/**
 * Шаблон формы смены пароля
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

switch($result["result"])
{
    case "incorrect":
	echo '<p>'.$this->diafan->_('Извините, вы не можете воспользоваться этой ссылкой.').'</p>';
	break;

    case "block":
	echo '<p>'.$this->diafan->_('Пользователь заблокирован.').'</p>';
	break;

    case "old":
	echo '<p>'.$this->diafan->_('Извините, время действия ссылки закончилось.').'</p>';
	break;

    case "success":
	echo '
	<form method="POST" action="" class="reminding_form ajax">
	<input type="hidden" name="action" value="change_password">
	<input type="hidden" name="module" value="reminding">
	<input type="hidden" name="code" value="'.$result["code"].'">
	<input type="hidden" name="user_id" value="'.$result["user_id"].'">

	<div class="form-group">
		<label>'.$this->diafan->_('Введите новый пароль').'</label><span style="color:red;">*</span>:</div>
	<input type="password" class="form-control" name="password" value="">
	<div class="errors text-danger error_password"'.($result["error_password"] ? '>'.$result["error_password"] : ' style="display:none">').'</div>

	<div class="infofield">'.$this->diafan->_('Повторите пароль').'<span style="color:red;">*</span>:</div>
	<input type="password" name="password2" value="">

	<br>
	<input class="btn btn-warning" type="submit" value="'.$this->diafan->_('Отправить', false).'">

	<div class="errors  text-danger error"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>

	<div class="required_field"><span style="color:red;">*</span> — '.$this->diafan->_('Поля, обязательные для заполнения').'</div>

	</form>';
	break;
}