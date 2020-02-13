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
 * Отправляет электронное письмо
 *
 * @param string|array $recipient получатель/получатели
 * @param string $subject тема письма
 * @param string $body содержание письма
 * @param string $from адрес отправителя
 * @return boolean
 */
function send_mail($recipient, $subject, $body, $from = '')
{
	Custom::inc('plugins/class.phpmailer.php');

	$mail = new PHPMailer();

	if (defined('SMTP_MAIL') && SMTP_MAIL && SMTP_HOST && SMTP_LOGIN && SMTP_PASSWORD)
	{
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = SMTP_HOST;  // SMTP server
		$mail->SMTPDebug  = MOD_DEVELOPER ? 1 : 0; // enables SMTP debug information (for testing)
										           // 1 = errors and messages
										           // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		if (SMTP_PORT)
		{
			$mail->Port   = SMTP_PORT;          // set the SMTP port for the GMAIL server
		}
		$mail->Username   = SMTP_LOGIN;    // SMTP account username
		$mail->Password   = SMTP_PASSWORD; // SMTP account password
	}
	
	$mail->SetFrom($from ? $from : EMAIL_CONFIG, TITLE);
	$mail->Subject = $subject;
	$mail->MsgHTML($body);

	if (is_array($recipient))
	{
		foreach ($recipient as $to)
		{
			$mail->AddAddress($to);
		}
	}
	elseif (strpos($recipient, ',') !== false)
	{
		$recipients = explode(',', $recipient);
		foreach ($recipients as $r)
		{
			$mail->AddAddress(trim($r));
		}
	}
	else
	{
		$mail->AddAddress($recipient);
	}
	$mailssend = $mail->Send();
	
	return $mailssend;
}
