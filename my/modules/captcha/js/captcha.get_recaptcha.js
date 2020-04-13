/**
 * JS-сценарий для reCAPTCHA
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

function create_recaptcha(element_id)
{
	$(".js_recaptcha_show, .recaptcha_show").show();
	$("#"+element_id).next(".js_recaptcha_show, .recaptcha_show").hide();
	Recaptcha.create(recaptcha_public_key, element_id, {theme : "clean"});
}

function onloadCallback() {
	create_recaptcha($('.js_captcha, .captcha').last().find('div').first().attr("id"));
}