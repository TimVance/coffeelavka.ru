<?php
/**
 * Установка модуля
 *
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined("DIAFAN"))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

class Feedback_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"site" => array(
			array(
				"id" => 7,
				"name" => array("Контакты"),
				"text" => array("<p>г. Москва, площадь Журавлева, 10, офис 206</p>
<p>Тел.: 8(495)-220-98-15</p>
<p>E-mail: info@coffeelavka.ru</p>
<script type=\"text/javascript\" charset=\"utf-8\" src=\"https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=fQ00DU6JA5EFOkJcCxYPS8HNvSU24sqA&amp;width=100%&amp;height=400&amp;lang=ru_RU&amp;sourceType=constructor\"></script>
<p><span style=\"font-size: 10pt;\"><strong>Здесь вы можете оставить ваши отзывы о работе нашей компании</strong></span></p>"),
				"rewrite" => "feedback",
				"sort" => 9,
				"menu" => "1",
				"module_name" => "feedback",
			),
			array(
				"id" => 30,
				"name" => array("Кофейни"),
				"text" => array("<p><span style=\"font-size: 10pt; font-family: helvetica, arial, sans-serif; background-color: #ffffff; color: #ffcc00;\">Ваши отзывы делают нас лучше!&nbsp;</span></p>
<hr>
<p><span style=\"font-size: 10pt; font-family: helvetica, arial, sans-serif; background-color: #ffff00;\"></span></p>
<p><strong><span style=\"font-size: 14pt; font-family: helvetica, arial, sans-serif;\">Кофелавка в ТЦ \"Серебряный дом\" </span></strong></p>
<p>м. Электрозаводская (1 мин. пешком)</p>
<p>Большая Семеновская, 16.</p>
<p>3 этаж. Расположена в зоне фудкорта.</p>
<p><img src=\"BASE_PATHuserfiles/editor/medium/429_1.jpg\" alt=\"\" title=\"\" width=\"300\" height=\"225\"></p>
<hr>
<p><strong><span style=\"font-size: 14pt; font-family: helvetica, arial, sans-serif;\">Кофелавка в ТЦ \"Щелково\" </span></strong><span style=\"font-size: 14pt; font-family: helvetica, arial, sans-serif;\"><span style=\"text-decoration: underline;\"><span style=\"font-size: 10pt;\"><a href=\"&lt;iframe src=&quot;https://yandex.ru/map-widget/v1/?z=12&amp;ol=biz&amp;oid=1558489699&quot; width=&quot;560&quot; height=&quot;400&quot; frameborder=&quot;0&quot;&gt;&lt;/iframe&gt;\">смотреть на карте</a></span></span></span></p>
<p>м. Щелковская (10 мин. на транспорте)</p>
<p>Щелковское шоссе, 100.</p>
<p>3 этаж. Расположена в зоне фудкорта.</p>
<p><img src=\"BASE_PATHuserfiles/editor/medium/430_2.jpg\" alt=\"\" title=\"\" width=\"300\" height=\"214\"></p>
<hr>
<p></p>
<p><strong><span style=\"font-size: 14pt; font-family: helvetica, arial, sans-serif;\">Кофелавка в ТЦ \"Шоколад\" (г. Реутов)</span></strong></p>
<p>м. Новогиреево м. Новокосино (10 мин. на транспорте)</p>
<p>2 к МКАД, 2</p>
<p>4 этаж. Расположена в зоне фудкорта.</p>
<p>Телефон: +7 925 768 06 96</p>
<p><img src=\"BASE_PATHuserfiles/editor/medium/431_byzq3hiraso.jpg\" alt=\"\" title=\"\" width=\"300\" height=\"234\"></p>
<p></p>
<hr>
<p><span style=\"font-family: helvetica, arial, sans-serif; font-size: 12pt; background-color: #ffffff;\"><strong><span style=\"font-size: 14pt; font-family: helvetica, arial, sans-serif;\">Отзыв о Кофелавке</span></strong></span></p>
<p style=\"text-align: left;\"><span style=\"font-family: 'times new roman', times, serif; font-size: 10pt; background-color: #ffffff; color: #ffcc00;\">(здесь можно оставить свой отзыв о нашем кофе, о вежливости и внимательности наших бариста, об удобстве и скорости обслуживания. Это поможет нам стать лучше для вас)</span></p>
<p><span style=\"font-family: 'arial black', sans-serif; font-size: 10pt; background-color: #ffffff; color: #ffcc00;\"></span></p>"),
				"rewrite" => "kofeyni",
				"sort" => 30,
				"menu" => "1",
				"module_name" => "feedback",
			),
			array(
				"id" => 35,
				"name" => array("Обратная связь"),
				"text" => array("<p>Мы будем благодарны за любые отзывы, советы и вопросы. Давайте вместе сделаем Кофелавку совершенной!</p>"),
				"rewrite" => "obratnaya-svyaz",
				"sort" => 35,
				"module_name" => "feedback",
			),
		),
		"config" => array(
			array(
				"name" => "captcha",
				"value" => "a:2:{i:0;s:1:\"0\";i:1;s:1:\"1\";}",
			),
			array(
				"name" => "add_message",
				"value" => "<div align=\"center\"><b>Спасибо за ваше сообщение!</b></div>",
			),
			array(
				"name" => "subject",
				"value" => "%title (%url). Обратная связь",
			),
			array(
				"name" => "message",
				"value" => "Здравствуйте!<br>Вы оставили сообщение в форме обратной связи на сайте %title (%url).<br><b>Сообщение:</b> %message <br><b>Ответ:</b> %answer",
			),
			array(
				"name" => "sendsmsadmin",
				"value" => "0",
			),
			array(
				"name" => "security",
				"value" => "",
			),
		),
		"feedback" => array(
			array(
				"readed" => "1",
				"param" => array("1" => "Константин", "6" => "89237101410", "7" => "Не отвечаете на почту! Нужен матчачай"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Олег", "6" => "+7(905)7442113", "7" => "Хочу узнать судьбу заказа 317"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Игорь", "6" => "29164385797", "7" => "Есть ли в наличии в офисе на площади Журавлева фильтро-пакеты M размера - 7шт?"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Вера", "6" => "89254641150", "7" => "Не могу с почты сделать заказ"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Елена", "6" => "89264064544", "7" => " "),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Павел", "6" => "+7 (901) 718-90-61", "7" => "По телефону с вами разговаривали, высылаю ссылку http://metricaopp.ru/"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Михаил", "6" => "89624403631", "7" => "Перезвоните, нужна консультация по чаю "),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Степан", "6" => "89637407293", "7" => "Добрый день! Я обещал вам прислать ссылку http://plazametrix.ru/"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Иван", "6" => "7 903 328-65-31", "7" => "Добрый день. Я маркетолог. Есть предложение для вашего сайта, посмотрите мою презентацию http://groupinbla.ru/ Жду ответа."),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Александр", "6" => "+79625819324", "7" => "Здравствуйте, как осуществляется доставка по России? С какими транспортными компаниями работаете?"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Екатерина", "6" => "89170942824", "7" => "Здравствуйте. У вас можно приобрести набор из 5 банок чая David rio по цене 4199 руб. Подскажите, в этот набор можно выбрать только банки по 899 руб, или и новинки по 1025 руб?<br />
И ещё-подойдет ли для их приготовления какая-то легкая кофеварка, например аэропресс? Там же надо с молоком его мешать? Или можно просто развести в горячем молоке?<br />
Спасибо."),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Екатерина", "6" => "89029129082", "7" => "по чаю латте"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Иван", "6" => "+79788475608", "7" => "номер транспортной"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ольга", "6" => "89152521844", "7" => "Если я физ лицо, а не Юр лицо - можно завтра подъехать купить чай латте 1816г?"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ирина", "6" => "89127406348", "7" => "Интересуют условия покупки чая-латте. "),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Баринова Екатерина", "6" => "89171454658", "7" => "Оплата заказа"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Денис", "6" => "89262845974", "7" => "Добрый день друзья.<br />
Меня зовут Денис, занимаюсь развитием проекта COFFOK - единое кофейное пространство. https://coffok.ru/<br />
Если говорить коротко, то сделали действительно удобный продукт, в котором подумали и об удобстве гостей, так и об удобстве самих заведений (тут и привлечение достойное и поток денег реализован удобно для самого бизнеса).<br />
<br />
С кем я могу дальше пообщаться на эту тему.<br />
<br />
Жду с нетерпением ответа от Вас.<br />
<br />
 С уважением,<br />
 Денис Грачев<br />
d@coffok.ru<br />
"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Павел", "6" => "+7914 927 4099", "7" => "по чаю девид рио"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Игнат", "6" => "+7925 318 0884"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Татьяна", "6" => "+7966 116 2829"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Юрий", "6" => "+7981 973 4724"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Марк Рубенович", "6" => "+7928 355 2668"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ирина", "6" => "+7915 995 1536"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Денис", "6" => "+7924 863 5657", "7" => "Заказ"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Денис", "6" => "+7924 863 5657", "7" => "Заказ"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "николай", "6" => "+8905 971 0310"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Надежда", "6" => "+7965 420 7906"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "вадим", "6" => "+7925 037 2329", "7" => "Белки,жиры,углеводы и калорийность вашего неалкализированного какао какова?"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ирина", "6" => "+7925 406 0258"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Оксана", "6" => "+7978 730 0447", "7" => "Крым"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Виктория", "6" => "+7962 292 5611", "7" => "Подтверждение заказа"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Юлия", "6" => "+7914 756 5569", "7" => "Чай латте"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Леонид", "6" => "+7916 264 0303", "7" => "Заказ 984"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Инна", "6" => "+7916 821 9892"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Александр", "6" => "+7925 291 2742"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Иван", "6" => "+7978 847 5608", "7" => "Чай"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Кристина", "6" => "+7966 300 6808"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Михаил", "6" => "+7921 655 1683", "7" => "интересует David Rio"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Илья", "6" => "+7963 963 8237", "7" => "Добрый день, хотел предложить услуги курьера, мне 30 лет, опыт более 5 лет, 300 руб доставка"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ира", "6" => "+7926 279 0103"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ирина", "6" => "+7926 734 0973"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Максим", "6" => "+7929 503 2016"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Светлана", "6" => "+7902 514 5295", "7" => "Интересует чай David Rio оптом"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Сергей", "6" => "+7926 892 8884", "7" => "Тест"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Александр", "6" => "+7915 099 7991", "7" => "Заказ"),
				"site_id" => 7,
			),
			array(
				"user_id" => 1,
				"readed" => "1",
				"param" => array("1" => "сергей", "6" => "+7926 892 8884", "7" => "нужна помощь"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Марина", "6" => "+7999 988 7949"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Марина", "6" => "+7999 988 7949"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Гнел", "6" => "+8925 924 1895"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Анна", "6" => "+7-918-022-93-39", "7" => "Чай David Rio"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Иван", "6" => "+7-988-381-45-44", "7" => "Заказ Дэвид Рио"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Зоя", "6" => "+7-966-028-56-46"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ксения", "6" => "+7-965-121-55-71", "7" => "Добрый день!<br />
Сегодня должны доставить заказ по адресу ул. Складочная, д.3, стр.7 к 12 часам. Подскажите пожалуйста, курьер сегодня приедет? Желательно до 17 часов. Спасибо!"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Андрей", "6" => "+7-911-268-64-01", "7" => "Доставка /оплата"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ануш", "6" => "+7-920-409-67-31", "7" => "Перезвоните срочно ."),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Кирилл", "6" => "+7-499-350-80-83"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Кирилл", "6" => "+7-495-150-46-72"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Марина", "6" => "+7-928-674-10-10", "7" => "вы работаете"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Дима", "6" => "+7-899-987-20-09", "7" => "Привет!<br />
<br />
Понравился ваш сайт, решил написать.<br />
<br />
Обратил внимание, что на вашем сайте плохо настроен сбор подписчиков и заявок. Наверняка, из-за этого конверсия сайта ниже, чем должна быть и вы теряете много клиентов. У меня небольшой интернет-магазин, в свое время решить проблему с конверсией помог вот этот сервис, посмотрите: https://converup.com/uvelichit-conversiju-saita-ili-internet-magazina <br />
<br />
Не буду озвучивать цифры, но я доволен. Уверен, вам он тоже поможет.<br />
<br />
Успехов!"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "алена", "6" => "+7-916-369-47-58"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Елена", "6" => "+7-926-857-04-94", "7" => "Свыше 1 кг кофе доставка бесплатная?"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Chris", "6" => "+7-800-653-80-24", "7" => "Hi Здравствуйте. Сервис продвижения в социальных сетях autosmo.ru предлагает вам раскрутить ваши профили. Наш сервис предусматривает продвижение в Инстаграм, Вконтакте, Одноклассники, Youtube, Twitter, Facebook. <br />
<br />
Нет никакой необходимости самостоятельно изучать технические аспекты данного процесса или тратить много времени на поиск живых подписчиков, что далеко не всегда позволяет достичь желаемых результатов.<br />
<br />
Мы знаем, как помочь вам получить новых клиентов по самой низкой цене и в кратчайшие сроки! В этом уже успели убедиться многие пользователи нашего сервиса, отзывы которых свидетельствуют о высокой оценке работы специалистов autosmo. <br />
<br />
Нашим клиентам, мы предлагаем круглосуточную техническую поддержку. У нас действует тикет-система, позволяющая быстро получать ответы на свои вопросы от консультантов компании.<br />
<br />
И это еще не все! наш Сервис  в честь нового года дарит купон на скидку в 30 % код купона NEW-YEAR<br />
Воспользоваться купоном может каждый желающий! Перейти на сайт http://autosmo.ru<br />
Инструкция по применению купона http://autosmo.ru/activ_kupon <br />
 http://autosmo.ru"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Андрей", "6" => "+7-985-912-65-54"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Сергей", "6" => "+7-963-227-79-77", "7" => "Доброе время суток! В первый раз связываюсь с Вами, меня интересует продукция David Rio. Способ оплаты и доставка до Тульской области."),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ольга", "6" => "+7-985-993-74-93", "7" => "ваш телефон, указанный на сайте постоянно занят.<br />
Хочу заказать какао 1 кг."),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Игорь", "6" => "+7-962-987-42-32", "7" => "Заказ латте чая"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Алексей", "6" => "+7-926-187-51-65", "7" => "Когда будет доставка на 6 штук chai david rio на Кутузовский проспект?<br />
Обещали сегодня, предупреждал, что смогу получить только до 7 вечера."),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Алексей", "6" => "+7-926-187-51-65", "7" => "Предыдущее обращение считать утратившим силу, Курьер всё доставил как раз в 18-40 :) спасибо большое!!!!"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Андрей Александрович", "6" => "+7-978-877-84-16", "7" => "Заказ кофе молотого"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Ольга", "6" => "+7-915-466-96-68", "7" => "Добрый день! Во вторник оформила заказ, сказали, что в течение 3-х дней будет в пункте выдачи и со мной свяжутся. Уже воскресенье, никто не связался. Что с моим заказом?!<br />
<br />
<br />
С уважением, Ольга!"),
				"site_id" => 7,
			),
			array(
				"readed" => "1",
				"param" => array("1" => "Дмитрий", "6" => "+7-915-205-01-12"),
				"site_id" => 7,
			),
		),
		"feedback_param" => array(
			array(
				"id" => 1,
				"name" => array("Ваше имя"),
				"type" => "text",
				"sort" => 7,
				"required" => "1",
				"site_id" => 7,
			),
			array(
				"id" => 6,
				"name" => array("Ваш телефон"),
				"type" => "phone",
				"sort" => 8,
				"required" => "1",
				"site_id" => 7,
			),
			array(
				"id" => 7,
				"name" => array("Ваш вопрос"),
				"type" => "textarea",
				"sort" => 9,
				"site_id" => 7,
			),
			array(
				"id" => 8,
				"name" => array("ваше имя"),
				"type" => "text",
				"sort" => 9,
				"required" => "1",
				"site_id" => 30,
			),
			array(
				"id" => 9,
				"name" => array("e-mail"),
				"type" => "text",
				"sort" => 10,
				"site_id" => 30,
			),
			array(
				"id" => 10,
				"name" => array("оставить отзыв"),
				"type" => "textarea",
				"sort" => 11,
				"site_id" => 30,
			),
			array(
				"id" => 11,
				"name" => array("выбрать кофейню"),
				"type" => "select",
				"sort" => 8,
				"required" => "1",
				"select" => array(array("id" => "1", "name" => array("в тц серебряный дом")), array("id" => "2", "name" => array("в тц щелково")), array("id" => "3", "name" => array("в тц шоколад")), array("id" => "4", "name" => array("в бц мега экспо"))),
				"site_id" => 30,
			),
			array(
				"id" => 12,
				"name" => array("Ваше имя"),
				"type" => "text",
				"sort" => 12,
				"required" => "1",
				"site_id" => 35,
			),
			array(
				"id" => 13,
				"name" => array("Ваш телефон"),
				"type" => "phone",
				"sort" => 13,
				"required" => "1",
				"site_id" => 35,
			),
			array(
				"id" => 14,
				"name" => array("Категория обращения"),
				"type" => "select",
				"sort" => 14,
				"select" => array(array("id" => "5", "name" => array("Отзыв по работе кофеен")), array("id" => "6", "name" => array("Отзыв по работе сайта")), array("id" => "7", "name" => array("Благодарность")), array("id" => "8", "name" => array("Жалоба")), array("id" => "9", "name" => array("Советы по улучшению")), array("id" => "10", "name" => array("Вопрос"))),
				"site_id" => 35,
			),
			array(
				"id" => 15,
				"name" => array("Обращение"),
				"type" => "textarea",
				"sort" => 15,
				"site_id" => 35,
			),
		),
	);
}