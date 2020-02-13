<?php
/**
 * Шаблон блока авторизации
 *
 * Шаблонный тег <insert name="show_login" module="registration" [template="шаблон"]>:
 * блок авторизации
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

if (! $result["user"])
{
	echo '<div class="row"><div class="block col-md-5">';
	// echo '<h3>'.$this->diafan->_('Вход на сайт').'</h3>';
	echo '<form method="post" action="'.$result["action"].'" class="login ajax">
	<input type="hidden" name="action" value="auth">
	<input type="hidden" name="module" value="registration">
	<input type="hidden" name="form_tag" value="registration_auth">
<div class="form-group">
	<label>Имя пользователя</label>
	<input type="text" class="form-control" name="name" placeholder="'.$this->diafan->_($this->diafan->configmodules("mail_as_login", "users") ? 'E-mail' : 'Имя пользователя').'" autocomplete="off">
</div>
<div class="form-group">
	<label>Пароль</label>
	<input type="password" class="form-control" name="pass" placeholder="'.$this->diafan->_('Пароль').'" autocomplete="off">
</div>
<div class="checkbox">
	<label for="not_my_computer"><input type="checkbox" id="not_my_computer" name="not_my_computer" value="1"> '.$this->diafan->_('Чужой компьютер').'
	</label>
</div>

	<input type="submit" class="btn btn-warning btn-sm" value="Войти"><br>';
	if (! empty($result["reminding"]))
	{
		echo '<a href="'.$result["reminding"].'" class="arrow-link black">'.$this->diafan->_('Забыли пароль?').'</a> ';
	}
	if(! empty($result["registration"]))
	{
		echo '<a href="'.$result["registration"].'" class="arrow-link black">'.$this->diafan->_('Регистрация').'</a>';
	}
	echo '<div class="text-danger errors error"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>';
	echo '</form>';

	if(! empty($result["use_loginza"]))
	{
		$this->diafan->_site->js_view[] = 'http://loginza.ru/js/widget.js';
	    echo '<br><a href="https://loginza.ru/api/widget?token_url='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']).'" class="loginza">
		<img src="http://loginza.ru/img/providers/yandex.png" alt="Yandex" title="Yandex">
		<img src="http://loginza.ru/img/providers/google.png" alt="Google" title="Google Accounts">
		<img src="http://loginza.ru/img/providers/vkontakte.png" alt="Вконтакте" title="Вконтакте">
		<img src="http://loginza.ru/img/providers/mailru.png" alt="Mail.ru" title="Mail.ru">
		<img src="http://loginza.ru/img/providers/twitter.png" alt="Twitter" title="Twitter">
		<img src="http://loginza.ru/img/providers/loginza.png" alt="Loginza" title="Loginza">
		<img src="http://loginza.ru/img/providers/myopenid.png" alt="MyOpenID" title="MyOpenID">
		<img src="http://loginza.ru/img/providers/openid.png" alt="OpenID" title="OpenID">
		<img src="http://loginza.ru/img/providers/webmoney.png" alt="WebMoney" title="WebMoney">
	    </a><br><br>';
	}
	echo '</div></div>';
}
else
{
	echo '<div class="row"><div class="block col-md-3"><ul class="list-group">';
	echo '<h3>'.$this->diafan->_('Профиль').'</h3>';
	if (! empty($result["avatar"]))
	{
		echo '<li class="list-group-item">
		<img src="'.BASE_PATH.USERFILES.'/avatar/'.$result["name"].'.png" width="'.$result["avatar_width"].'" height="'.$result["avatar_height"].'" alt="'.$result["fio"].' ('.$result["name"].')" class="avatar profile-hello-avatar">';
	}
	elseif(! empty($result["avatar_none"]))
	{
		echo '<li class="list-group-item">';
	}
	echo '<div class="profile-hello-text">
			'.$this->diafan->_('Здравствуйте').',<br>';

		echo $result["fio"];
	    echo '!
		</div>';

		if($result['userpage'])
		{
			echo '<li class="list-group-item"><a href="'.$result['userpage'].'">'.$this->diafan->_('Личная страница').'</a></li>';
		}
        if(! empty($result["usersettings"]))
		{
			echo '<li class="list-group-item"><a href="'.$result["usersettings"].'">'.$this->diafan->_('Настройки').'</a></li>';
		}
		if (!empty($result['messages']))
		{
			echo '<li class="list-group-item"><a href="'.$result['messages'].'">'.$result['messages_name'];
			if($result['messages_unread'])
			{
			    echo ' (<b>'.$result['messages_unread'].'</b>)';
			}
			echo '</a></li>';
		}




	echo '<li class="list-group-item"><a href="'.BASE_PATH_HREF.'logout/?'.rand(0, 99999).'" class="button">'.$this->diafan->_('Выйти', false).'</a>';
	echo '</ul></div></div>';
}