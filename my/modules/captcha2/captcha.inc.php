<?php
/**
 * Подключение для работы с капчей
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
 * Captcha_inc
 */
class Captcha_inc extends Model
{
	/**
	 * Выводит капчу
	 * 
	 * @param string $modules метка капчи
	 * @param string $error ошибка ввода кода, если запрос передан не через Ajax
	 * @param boolean $is_update капча генерируется для обновления
	 * @return string
	 */
	public function get($modules = "modules", $error = "", $is_update = false)
	{
		switch($this->diafan->configmodules('type', 'captcha'))
		{
			case 'reCAPTCHA':
				if(isset($_POST["recaptcha_challenge_field"]))
				{
					unset($_POST["recaptcha_challenge_field"]);
					return "recaptcha";
				}
				else
				{
					$result["public_key"] = $this->diafan->configmodules('recaptcha_public_key', 'captcha');
					$result["error"] = $error;
					$result["modules"] = $modules;
					$this->diafan->_site->js_view[] = 'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js';
					return $this->diafan->_tpl->get('get_recaptcha', 'captcha', $result);
				}

			case 'qa':
				return $this->get_qa('', $is_update);

			default:
				return $this->diafan->_tpl->get(($is_update ? 'get_form' : 'get'), 'captcha', array("modules" => $modules, "error" => $error));
		}
	}

	/**
	 * Проверяет подключена ли капта в настройках модуля
	 * 
	 * @param string $module названием модуля
	 * @param integer $site_id страница сайта с подключенным модулем
	 * @return boolean
	 */
	public function configmodules($module, $site_id = 0)
	{
		if($this->diafan->configmodules('captcha', $module, $site_id) && $this->diafan->configmodules('captcha', $module, $site_id) === '1')
		{
			return true;
		}
		if ($this->diafan->configmodules('captcha', $module, $site_id) && in_array($this->diafan->_users->role_id, unserialize($this->diafan->configmodules('captcha', $module, $site_id))))
		{
			return true;
		}
		return false;
	}

	/**
	 * Подключает капчу «Вопрос-Ответ»
	 * 
	 * @param string $error ошибка ввода кода, если запрос передан не через Ajax
	 * @param boolean $is_update капча генерируется для обновления
	 * @return string
	 */
	private function get_qa($error = "", $is_update = false)
	{
		$tpl_result = array("error" => $error, "text" => '', "answers" => array());
		
		$capcha = DB::query_fetch_array("SELECT [name], id, is_write FROM {captcha} WHERE trash='0' AND [act]='1' ORDER BY RAND () LIMIT 1");
		if($capcha)
		{
			$_SESSION["captcha_id"] = $capcha["id"];
			$tpl_result["text"] = $capcha["name"];
			if(! $capcha["is_write"])
			{
				$tpl_result["answers"] = DB::query_fetch_all("SELECT [text], id FROM {captcha_answers} WHERE captcha_id=%d ORDER BY RAND()", $capcha["id"]);
			}
		}
		return $this->diafan->_tpl->get(($is_update ? 'get_qa_form' : 'get_qa'), 'captcha', $tpl_result);
	}

	/**
	 * Проверяет правильность ввода капчи
	 * 
	 * @param string $modules метка капчи
	 * @return string|boolean false
	 */
	public function error($modules = "modules")
	{
		switch($this->diafan->configmodules('type', 'captcha'))
		{
			case 'reCAPTCHA':
				return $this->error_recaptcha();

			case 'qa':
				return $this->error_qa();

			default:
				return $this->error_captcha($modules);
		}
	}

	/**
	 * Проверяет правильность reCAPTCHA
	 * 
	 * @return string|boolean false
	 */
	private function error_recaptcha()
	{	
		if(empty($_POST["recaptcha_challenge_field"]))
		{
			$_POST["recaptcha_challenge_field"] = '';
		}
		if(empty($_POST["recaptcha_response_field"]))
		{
			$_POST["recaptcha_response_field"] = '';
		}
		$fp = fsockopen('www.google.com', 80);
		if($fp)
		{
			$param = "privatekey=".urlencode($this->diafan->configmodules('recaptcha_private_key', 'captcha'))."&"
			."remoteip=".urlencode(getenv('REMOTE_ADDR'))."&"
			."challenge=".urlencode($_POST["recaptcha_challenge_field"])."&"
			."response=".urlencode($_POST["recaptcha_response_field"]);
			$size = strlen($param);

			fputs($fp, "POST http://www.google.com/recaptcha/api/verify HTTP/1.1\r\n"
			."Host: www.google.com\r\n"
			."Content-type: application/x-www-form-urlencoded\r\n"
			."Content-Length: ".$size."\r\n"
			."Connection: Close\r\n\r\n"
			.$param);

			$result = false;
			$resultstr = '';
			while(!feof($fp))
			{
				$response = fgets($fp);
				if($result)
				{
					$resultstr .= $response;
				}
				if(strpos($response, "Connection: close") !== false)
				{
					$result = true;
				}
			}
			fclose($fp);
			if(strpos($resultstr, 'true') !== false && strpos($resultstr, 'success'))
			{
				return false;
			}
			else
			{
				if(MOD_DEVELOPER && strpos($resultstr, 'invalid-site-private-key') !== false)
				{
					return $this->diafan->_('Проверьте Rrivate Key для сервиса reCAPTCHA.', false);
				}
				else
				{
					return $this->diafan->_('Неправильно введен защитный код.', false);
				}
			}
		}
		else
		{
			return $this->diafan->_('Невозможно подключиться к северу reCAPTCHA.', false);
		}

		return false;
	}

	/**
	 * Проверяет правильность ввода стандартной капчи
	 * 
	 * @return string|boolean false
	 */
	private function error_captcha($modules)
	{
		//Защитный код не введен
		if (empty($_POST['captcha']) || empty($_POST['captchaint']))
			return $this->diafan->_('Введите защитный код', false);

		//В сессии не записан код с данным идентификатором captchaint
		if (! isset($_SESSION['captcha'][$modules][$_POST['captchaint']])
		||
		//код из сессии не соответствует введенному. регистр не учитывается
		strtoupper($_SESSION['captcha'][$modules][$_POST['captchaint']]) != strtoupper($_POST['captcha']))
			return $this->diafan->_('Неправильно введен защитный код.', false);

		//очищаем из сессии запись с данным идентификатором
		unset($_SESSION['captcha'][$modules][$_POST['captchaint']]);
		return false;
	}

	/**
	 * Проверяет правильность ввода капчи «Вопрос-Ответ»
	 * 
	 * @return string|boolean false
	 */
	private function error_qa()
	{
		if(empty($_SESSION["captcha_id"]))
		{
			return $this->diafan->_('Выберите правильный ответ.', false);
		}
		$row = DB::query_fetch_array("SELECT * FROM {captcha} WHERE id=%d AND trash='0'", $_SESSION["captcha_id"]);
		if(! $row)
		{
			return $this->diafan->_('Выберите правильный ответ.', false);
		}
		if($row["is_write"])
		{
			if(empty($_POST["captcha_answer"]))
			{
				return $this->diafan->_('Впишите правильный ответ.', false);
			}
			if(! DB::query_result("SELECT COUNT(*) FROM {captcha_answers} WHERE trash='0' AND captcha_id=%d AND [text]='%s'", $row["id"], utf::strtolower($_POST["captcha_answer"])))
			{
				return $this->diafan->_('Ответ не верный.', false);
			}
			return false;
		}
		else
		{
			if(empty($_POST["captcha_answer_id"]))
			{
				return $this->diafan->_('Выберите правильный ответ.', false);
			}
			if(! DB::query_result("SELECT COUNT(*) FROM {captcha_answers} WHERE trash='0' AND captcha_id=%d AND id=%d AND is_right='1'", $_SESSION["captcha_id"], $_POST["captcha_answer_id"]))
			{
				return $this->diafan->_('Ответ не верный.', false);
			}
		}
		return false;
	}
}