<?php
/**
 * Шаблон блока авторизации2
 *
 * Шаблонный тег <insert name="show_login" module="registration" [template="шаблон"]>:
 * блок авторизации
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2015 OOO «Диафан» (http://www.diafan.ru/)
 */
if (!defined('DIAFAN'))
{
    include dirname(dirname(dirname(__FILE__))).'/includes/404.php';
}

if (!$result["user"])
{


echo '<ul class="nav navbar-nav navbar-right navbar-right_mod">

<li><a href="'.BASE_PATH_HREF.'user/avtorizatsiya" >Войти</a></li>
<li><a href="'.$result["registration"].'">Зарегистрироваться</a></li></ul>';


/*echo '<a href="#"><span class="top-icon top-icon-user"></span>
<span class="hide-for-xs">Вход</span>
</a>'; */



}
else
{

echo '<ul class="nav navbar-nav navbar-right navbar-right_mod">
<li><a href="'.$result['userpage'].'">Личный кабинет</a></li>
<li><a href="'.BASE_PATH_HREF.'logout/?'.rand(0, 99999).'">Выйти</a></li>
</ul>';


/*echo '<a href="'.$result['userpage'].'"><span class="top-icon top-icon-user"></span>
<span class="hide-for-xs">Личный кабинет</span>
</a>';

echo '<a class="logaut" href="'.BASE_PATH_HREF.'logout/?'.rand(0, 99999).'">
<span class="hide-for-xs">Выйти</span>
</a>'; */

/*	echo '<div class="block profile-block">';
	echo '<h3>'.$this->diafan->_('Профиль').'</h3>';
	if (!empty($result["avatar"]))
	{
		echo '<img src="'.BASE_PATH.USERFILES.'/avatar/'.$result["name"].'.png" width="'.$result["avatar_width"].'" height="'.$result["avatar_height"].'" alt="'.$result["fio"].' ('.$result["name"].')" class="avatar profile-hello-avatar">';
	}
	echo '<div class="profile-hello-text">
			'.$this->diafan->_('Здравствуйте').',<br>';

		echo $result["fio"];
	    echo '!
		</div>';

		echo '<ul class="menu">';
		if($result['userpage'])
		{
			echo '<li><a href="'.$result['userpage'].'">'.$this->diafan->_('Личная страница').'</a></li>';
		}
        if(! empty($result["usersettings"]))
		{
			echo '<li><a href="'.$result["usersettings"].'">'.$this->diafan->_('Настройки').'</a></li>';
		}
		if (!empty($result['messages']))
		{
			echo '<li><a href="'.$result['messages'].'">'.$result['messages_name'];
			if($result['messages_unread'])
			{
			    echo ' (<b>'.$result['messages_unread'].'</b>)';
			}
			echo '</a></li>';
		}
	    echo '</ul>';  */



/*	echo '<form action="'.BASE_PATH_HREF.'logout/?'.rand(0, 99999).'" method="POST">
			<input type="submit" value="'.$this->diafan->_('Выйти', false).'">
		</form>';
	echo '</div>';*/
}