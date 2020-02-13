<?php
/**
 * On-line консультант, система RedHelper
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

class Consultant_admin_redhelper extends Frame_admin
{
	/**
	 * Основная страница модуля
	 * @return void
	 */
	public function show()
	{
		if(! empty($_POST["consultant_action"]))
		{
			switch($_POST["consultant_action"])
			{
				case "consultant_register":
					$this->consultant_register();
					break;
				case "consultant_config":
					$this->consultant_config();
					break;
				default:
					Custom::inc('includes/404.php');
			}
		}
		if(! empty($_GET["consultant_action"]))
		{
			switch($_GET["consultant_action"])
			{
				case "consultant_config_form":
					return $this->consultant_config_form();
				default:
					Custom::inc('includes/404.php');
			}
		}
		if(! $this->diafan->configmodules("login", "consultant"))
		{
			echo '<p>Для подключения онлайн-консультанта <a href="http://redhelper.ru/?p=2002141" target="_blank">RedHelper</a> нужно дополнительно зарегистрироваться на их сайте.<br> Это можно сделать по <a href="http://redhelper.ru/?p=2002141" target="_blank">ссылке</a>, либо заполнив поля ниже. Укажите Ваш e-mail, на который Вам придет письмо-памятка, а также придумайте любой логин и пароль, который будет использоваться консультантами сайта. </p>';
			$this->consultant_register_form();
			echo '<p style="margin-top:200px; color:gray;">Если Вы уже регистрировались и у Вас есть логин и пароль сервиса RedHelper, внесите их в <a href="?consultant_action=consultant_config_form">настройки модуля</a>.</p>';
		}
		else
		{
			$password = $this->diafan->configmodules("redhelper_password", "consultant");
			echo '<p><img src="http://redhelper.ru/media/graphics/logo.png" alt="" align="left" hspace="10">Вы зарегистрированы в системе Red Helper.<br><br>
			Ваш логин и пароль: <b>'
			.$this->diafan->configmodules("redhelper_login", "consultant").'</b> и <b>'.($password ? $password : 'пароль не указан').'</b>.<br><br>
			<a href="http://redhelper.ru/my/welcome" target="_blank">Личный кабинет на сайте redhelper.ru</a><br><br>
			</p>';
			
			echo '<p>Для начала работы с консультантом нужно проделать три шага:</p>';
			
			echo '<p>1. Добавьте в шаблон DIAFAN.CMS (<i>/themes/site.php</i>) шаблонный тег<br> <code><span style="color: #000000"><span style="color: #0000BB">&lt;insert</span> <span style="color: #007700">name=</span><span style="color: #DD0000">&quot;show_block&quot;</span> <span style="color: #007700">module=</span><span style="color: #DD0000">&quot;consultant&quot</span> <span style="color: #007700">system=</span><span style="color: #DD0000">&quot;redhelper&quot</span><span style="color: #0000BB">&gt;</span></span></code>.</p>';
			
			echo '<p>2. <a href="http://redhelper.ru/RedHelperSetup.exe"><b>Скачайте</b></a> и установите приложение оператора. Это независимая программа, устанавливаемая на Ваш компьютер (Windows), позволяет наблюдать за посетителями, отвечать на их вопросы и многое другое.<br>Для других операционных систем и мобильных устройств Вы можете <a href="https://redhelper.zendesk.com/forums/21556502-jabber-redhelper" target="_blank">использовать любой jabber клиент</a>.
			После установки для входа в приложение используйте логин и пароль, обозначенные выше.
			</p>';
			
			echo '<p>3. <a href="'.BASE_PATH_HREF.'consultant/redhelper/?consultant_action=consultant_config_form"><b>Настройте внешний вид консультанта</b></a> на Вашем сайте. <br><br><br><br>
			Полные настройки консультанта, загрузка фотографий Ваших сотрудников, оплата дополнительных услуг, изменение пароля и прочее в <a href="http://redhelper.ru/my/welcome" target="_blank">личном кабинете на сайте redhelper.ru</a></p>';
		}
	}
	
	/**
	 * Форма регистрации в системе RedHelper
	 *
	 * @return void
	 */
	private function consultant_register_form()
	{
		echo '<form method="POST" action="">
		<input type="hidden" name="consultant_action" value="consultant_register">
		<p>E-mail: <input type="text" name="consultant_email" value="'.(!empty($_POST["consultant_email"]) ? str_replace('"', '&quot;', $_POST["consultant_email"]) : '').'"></p>
		<p>Логин: <input type="text" name="consultant_login" value="'.(!empty($_POST["consultant_login"]) ? str_replace('"', '&quot;', $_POST["consultant_login"]) : '').'"></p>
		<p>'.$this->diafan->_('Пароль').': <input type="password" name="consultant_password" value="'.(!empty($_POST["consultant_password"]) ? str_replace('"', '&quot;', $_POST["consultant_password"]) : '').'"></p>
		<input type="submit" class="button" value="'.$this->diafan->_('Зарегистрироваться').'">
		</form>';
	}
	
	/**
	 * Регистрация в системе RedHelper
	 *
	 * @return void
	 */
	private function consultant_register()
	{
		if($this->diafan->configmodules("login", "consultant"))
		{
			$this->diafan->redirect(BASE_PATH_HREF.'consultant/redhelper/');
		}
		if(empty($_POST["consultant_login"]) || empty($_POST["consultant_email"]) || empty($_POST["consultant_password"]))
		{
			echo '<div class="error">'.$this->diafan->_('Заполните все поля.').'</div>';
			return;
		}
		$fp = fsockopen('redhelper.ru', 80);
		if($fp)
		{;
			$data = http_build_query(array(
				"login" => $_POST["consultant_login"],
				"email" => $_POST["consultant_email"],
				"password" => $_POST["consultant_password"],
				"locale" => "ru",
				"ref" => 2002141
			));
			fputs($fp, "POST http://redhelper.ru/my/register.jsp HTTP/1.1\r\n");
			fputs($fp, "Host: redhelper.ru\r\n");
			fputs($fp, "Content-Type: application/x-www-form-urlencoded;charset=UTF-8\r\n");
			fputs($fp, "Content-length: ".utf::strlen($data)."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $data);

			while(!feof($fp))
			{
				$result = fgets($fp, 128);
				//echo $result;
			}
			fclose($fp);
			//echo $result;
			switch($result)
			{
				case "no such email":
				case "email incorrect":
					echo '<div class="error">'.$this->diafan->_('Не существующий e-mail адрес.').'</div>';
					break;
				case "exist":
					echo '<div class="error">'.$this->diafan->_('Пользователь с таким логином уже существует.').'</div>';
					break;
				case "success":
				default:
					$this->diafan->configmodules("redhelper_login", "consultant", 0, _LANG, $_POST["consultant_login"]);
					$this->diafan->configmodules("redhelper_password", "consultant", 0, _LANG, $_POST["consultant_password"]);
					$this->diafan->redirect(BASE_PATH_HREF.'consultant/redhelper/');
					break;
				
			}
		}
	}
	
	/**
	 * Настройки консультанта
	 *
	 * @return void
	 */
	private function consultant_config_form()
	{
		$fields = array('login', 'password', 'color', 'place', 'small', 'chatX', 'chatY', 'header', 'topText', 'welcome', 'inviteTime', 'chatWidth', 'chatHeight');
		foreach ($fields as $field)
		{
			$$field = (!empty($_POST["consultant_".$field]) ? $_POST["consultant_".$field] : $this->diafan->configmodules('redhelper_'.$field, "consultant"));
		}

		echo '<form method="POST" action="">
		<input type="hidden" name="consultant_action" value="consultant_config">
		<p>'.$this->diafan->_('Логин').': <input type="text" name="consultant_login" value="'.str_replace('"', '&quot;', $login).'"></p>
		<p>'.$this->diafan->_('Пароль').': <input type="text" name="consultant_password" value="'.str_replace('"', '&quot;', $password).'"></p>
		<p>'.$this->diafan->_('Цвет кнопки').': <input type="text" name="consultant_color" value="'.str_replace('"', '&quot;', $color).'"></p>
		<p>'.$this->diafan->_('Расположение').': <select name="consultant_place">
		<option value="left"'.($place == 'left' ? ' selected' : '').'>'.$this->diafan->_('слева').'</option>
		<option value="right"'.($place == 'right' ? ' selected' : '').'>'.$this->diafan->_('справа').'</option>
		<option value="top"'.($place == 'top' ? ' selected' : '').'>'.$this->diafan->_('сверху').'</option>
		</select></p>
		<p><label for="input_consultant_small">'.$this->diafan->_('Сокращенный вид').'</label>: <input type="checkbox" name="consultant_small" id="input_consultant_small" value="1"'.($small ? ' checked' : '').'></p>
		<p>'.$this->diafan->_('Положение чата по горизонтали').': <input type="text" name="consultant_chatX" value="'.$chatX.'" size="10"></p>
		<p>'.$this->diafan->_('Положение чата по вертикали').': <input type="text" name="consultant_chatY" value="'.$chatY.'" size="10"></p>
		<p>'.$this->diafan->_('Верхний текст с названием компании').': <input type="text" name="consultant_header" value="'.$header.'" size="40"></p>
		<p>'.$this->diafan->_('Текст под названием компании').': <input type="text" name="consultant_topText" value="'.$topText.'" size="40"></p>
		<p>'.$this->diafan->_('Текст приглашения').': <input type="text" name="consultant_welcome" value="'.$welcome.'" size="40"></p>
		<p>'.$this->diafan->_('Время задержки на выдачу приглашения').': <input type="text" name="consultant_inviteTime" value="'.$inviteTime.'" size="10"></p>
		<p>'.$this->diafan->_('Ширина окна чата').': <input type="text" name="consultant_chatWidth" value="'.$chatWidth.'" size="10"></p>
		<p>'.$this->diafan->_('Высота окна чата').': <input type="text" name="consultant_chatHeight" value="'.$chatHeight.'" size="10"></p>
		<input type="submit" class="button" value="'.$this->diafan->_('Сохранить').'">
		</form>';
	}
	
	/**
	 * Сохранение настроек консультанта
	 *
	 * @return void
	 */
	private function consultant_config()
	{
		$fields = array('login', 'password', 'color', 'place', 'small', 'chatX', 'chatY', 'header', 'topText', 'welcome', 'inviteTime', 'chatWidth', 'chatHeight');
		foreach ($fields as $field)
		{
			$this->diafan->configmodules('redhelper_'.$field, "consultant", 0, _LANG, (! empty($_POST["consultant_".$field]) ? $_POST["consultant_".$field] : ''));
		}
		$this->diafan->redirect(BASE_PATH_HREF.'consultant/redhelper/success1/?consultant_action=consultant_config_form');
	}
}