<?php
/**
 * @package    DIAFAN.CMS
 *
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
 * Session
 * 
 * Работа с сессиями в пользовательской части
 */
class Session extends Diafan
{
	/*
	 * @var string название сессии
	 */
	public $name;

	/*
	 * @var string идентификатор сессии
	 */
	public $id;

	/**
	 * Стартует сессию
	 * 
	 * @return void
	 */
	public function init()
	{
		$this->setCookieDomain();
		session_cache_limiter('private_no_expire');
		$this->name = 'SESS'.md5($this->getHost().REVATIVE_PATH);
		session_name($this->name);
		session_set_save_handler(array(&$this, 'open'), array(&$this, 'close'), array(&$this, 'read'),
		                         array(&$this, 'write'), array(&$this, 'destroy'), array(&$this, 'gc'));
		session_start();
		$this->id = session_id();
	}

	/**
	 * Открывает сессию
	 * 
	 * @return boolean true
	 */
	public function open()
	{
		return true;
	}

	/**
	 * Закрывает сессию освобождает ресурсы
	 * 
	 * @return boolean true
	 */
	public function close()
	{
		return true;
	}

	/**
	 * Читает сессию
	 * 
	 * @param string $key идентификатор сессии
	 * @return string
	 */
	public function read($key)
	{
		Dev::register_shutdown_function('session_write_close');

		if (! isset($_COOKIE[$this->name]))
		{
			return '';
		}

		$user = DB::query_fetch_object("SELECT u.*, s.* FROM {users} u INNER JOIN {sessions} s ON u.id = s.user_id"
		    ." WHERE s.session_id = '%s' AND s.hostname='%s' AND s.user_agent='%s'",
		    $key, getenv('REMOTE_ADDR'), getenv('HTTP_USER_AGENT'));
		if ($user && $user->id > 0)
		{
			$this->diafan->_users->set($user);
			return $user->session;
		}
		else
		{
			$session = DB::query_result("SELECT session FROM {sessions} WHERE session_id='%s' AND hostname='%s'"
										." AND user_agent='%s' LIMIT 1",
				$key, getenv('REMOTE_ADDR'), getenv('HTTP_USER_AGENT'));
			return $session;
		}
	}

	/**
	 * Записывает данные в сессию
	 * 
	 * @param string $key идентификатор сессии
	 * @param string $value серилизованные данные сессии
	 * @return void
	 */
	public function write($key, $value)
	{
		$row = DB::query_fetch_array("SELECT session_id, hostname, user_agent FROM {sessions} WHERE session_id='%s'", $key);

		if(empty($row) || getenv('REMOTE_ADDR') != $row["hostname"] || getenv('HTTP_USER_AGENT') != $row["user_agent"])
		{
			if (! empty($row))
			{
				DB::query("DELETE FROM {sessions} WHERE session_id='%h'", $key);
			}
			if ($this->diafan->_users->id || $value || count($_COOKIE))
			{
				DB::query("INSERT INTO {sessions} (session_id, user_id, hostname, user_agent, session, timestamp)"
				." VALUES ('%s', %d, '%s', '%s', '%s', %d)",
				$key, $this->diafan->_users->id, getenv("REMOTE_ADDR"), getenv('HTTP_USER_AGENT'), $value, time());
			}
		}
		else
		{
			DB::query("UPDATE {sessions} SET user_id=%d, session='%s', timestamp=%d WHERE session_id='%s'",
					  $this->diafan->_users->id, $value, time(), $key);
		}
	}

	/**
	 * Чистит мусор - удаляет сессии старше $lifetime
	 * @return void
	 */
	public function gc() 
	{
		$lifetime = 1209600; // 2 weeks
		DB::query("DELETE FROM {sessions} WHERE timestamp<%d", time() - $lifetime);
	}

	/**
	 * Удаляет ссессию
	 * @param string $key идентификатор сессии
	 * @return void
	 */
	public function destroy($key = '')
	{
		if(! $key)
		{
			$key = $this->id;
		}
		DB::query("DELETE FROM {sessions} WHERE session_id='%s' AND hostname='%s' AND user_agent='%s'",
		          $key, getenv('REMOTE_ADDR'), getenv('HTTP_USER_AGENT'));
		$_SESSION = null;
		$this->diafan->_users->id = 0;
	}

	/**
	 * Определяет продолжительность сессии
	 * 
	 * @return void
	 */
	public function duration()
	{
		if(! empty($_POST['not_my_computer']))
		{
			$duration = 0;
		}
		else
		{
			$duration = 1209600;
		}
		$params = session_get_cookie_params();
		if($params['lifetime'] != $duration)
		{
			session_set_cookie_params($duration);
			session_regenerate_id(false);
		}
	}

	public function prepare($config)
	{
		if(isset($config))
		{
			self::$config;
		}
	}
	
	protected function getHost() {
		$host = getenv('HTTP_HOST');
		$hostParts = explode('.', $host);
		$cookieParts = array_slice(array_reverse($hostParts), 0, 2);
		return $cookieParts[1] . '.' . $cookieParts[0];
	}
	
	protected function setCookieDomain() {
		ini_set('session.cookie_domain', '.' . $this->getHost());
	}
}