<?php
/**
 * On-line консультант, система Livetex
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

class Consultant_admin_livetex extends Frame_admin
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
				case "consultant_manual":
					return $this->consultant_manual();
				default:
					Custom::inc('includes/404.php');
			}
		}

		echo '<p>Для подключения онлайн-консультанта <a href="http://billing.livetex.ru/reg/736/" target="_blank">LiveTex</a> нужно дополнительно зарегистрироваться на их сайте.<br> Это можно сделать по <a href="http://billing.livetex.ru/reg/736/" target="_blank">ссылке</a>. Затем необходимо внести персональный код в поле ниже.</p><form method="POST" action="">
		<input type="hidden" name="consultant_action" value="consultant_config">
		'.$this->diafan->_('Ваш персональный код сайта').': <input type="text" name="consultant_id" value="'.str_replace('"', '&quot;', $this->diafan->configmodules('livetex_id', "consultant")).'">
		<input type="submit" class="button" value="'.$this->diafan->_('Сохранить').'">
		</form>
		<p><a href="'.BASE_PATH_HREF.'consultant/?consultant_action=consultant_manual">Как получить персональный ключ для Livetex</a></p>';
	}
	
	/**
	 * Как получить персональный ключ для Livetex
	 *
	 * @return void
	 */
	private function consultant_manual()
	{
		echo '<h1>Как получить персональный ключ для Livetex</h1>';
		
		echo '<p>Чтобы подключить приложение, вам необходимо получить от Livetex ваш персональный код сайта.</p>';
		echo '<p>Для этого создайте свой Livetex аккаунт, перейдя по <a href="http://billing.livetex.ru/reg/736/" target="_blank">ссылке</a>. После регистрации вы получите специальный код в таком виде:</p>';
		echo '<div style="border: 1px solid #ccc;margin: 20px 0;padding: 10px;background-color: #f2f2f2;">
		&lt;script type=\'text/javascript\'&gt; /* build:::7 */<br />&nbsp;&nbsp; &nbsp;var liveTex = true,<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;liveTexID = <b>55899</b>,<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;liveTex_object = true;<br />&nbsp;&nbsp; &nbsp;(function() {<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;var lt = document.createElement(\'script\');<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;lt.type =\'text/javascript\';<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;lt.async = true;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lt.src = \'http://cs15.livetex.ru/js/client.js\';<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;var sc = document.getElementsByTagName(\'script\')[0];<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;if ( sc ) sc.parentNode.insertBefore(lt, sc);<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;else&nbsp; document.documentElement.firstChild.appendChild(lt);<br />&nbsp;&nbsp; &nbsp;})();<br />&lt;/script&gt;</div>';
		echo '<p>Где <b>55899</b> – код вашего сайта.</p>';
		echo '<p>Сохрание полученный код в поле «Ваш персональный код сайта» в <a href="'.BASE_PATH_HREF.'consultant/">настройках модуля</a>.</p>';
		echo '<p>Затем добавьте в шаблон DIAFAN.CMS (<i>/themes/site.php</i>) шаблонный тег<br> <code><span style="color: #000000"><span style="color: #0000BB">&lt;insert</span> <span style="color: #007700">name=</span><span style="color: #DD0000">&quot;show_block&quot;</span> <span style="color: #007700">module=</span><span style="color: #DD0000">&quot;consultant&quot</span> <span style="color: #007700">system=</span><span style="color: #DD0000">&quot;livetex&quot</span><span style="color: #0000BB">&gt;</span></span></code>.</p>';
	}
	
	/**
	 * Сохранение настроек консультанта
	 *
	 * @return void
	 */
	private function consultant_config()
	{
		$this->diafan->configmodules('livetex_id', "consultant", 0, _LANG, (! empty($_POST["consultant_id"]) ? $_POST["consultant_id"] : ''));
		$this->diafan->redirect(BASE_PATH_HREF.'consultant/success1/');
	}
}