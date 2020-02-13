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

class Site_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"config" => array(
			array(
				"name" => "keywords",
				"value" => "1",
			),
			array(
				"name" => "images_variations_element",
				"value" => "a:2:{i:0;a:2:{s:4:\"name\";s:5:\"large\";s:2:\"id\";s:1:\"4\";}i:1;a:2:{s:4:\"name\";s:6:\"medium\";s:2:\"id\";s:1:\"4\";}}",
			),
			array(
				"name" => "images_variations",
				"value" => "",
			),
		),
		"site" => array(
			array(
				"id" => 1,
				"name" => array("ПОЧЕМУ У НАС ЛУЧШИЙ КОФЕ?"),
				"text" => array("<div><span style=\"font-size: 14pt;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></div>
<div></div>
<div><span style=\"font-size: 12pt;\"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Мы продаем фермерский кофе!</strong></span></div>
<div>Фермерский кофе -&nbsp;особый, такого не найдешь в супермаркетах! Мы продаем только высокогорную 100% арабику. Некоторые&nbsp; сорта можно проследить от конкретной фермы и её владельца, где бережно выращиваются, собираются и обрабатываются кофейные ягоды, до прилавка кофейни. Весь наш кофе выращен без применения вредных химических веществ, он экологически чистый, отборный и очень вкусный.&nbsp;В ассортименте есть&nbsp;уникальные лоты, которые&nbsp; представляют собой результаты совместных экспериментов обжарщика и фермера. Попробуйте продукт, созданный влюбленными в своё дело людьми!&nbsp;</div>
<div></div>
<div><strong><span style=\"font-size: 12pt;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Лучшие обжарщики Москвы!</span> </strong></div>
<div>Обжарка в мире производителей кофе не зря именуется магией: после обжарки до 30% веса зерна составляют новые вещества и соединения. Какими они будут, получится ли раскрыть потенциал высокогорной арабики в чашке &ndash; во многом зависит от качества оборудования и профессионализма обжарщика. Наш обжарщик входит в 10-ку лучших в мире, работает на первоклассном оборудовании с отобранными на фермах лучшими сортами арабики. Обжарка производится каждую неделю &ndash; это гарантия свежести и вкуса!</div>
<div></div>
<div></div>
<div><strong><span style=\"font-size: 12pt;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Самая Быстрая доставка кофе в Москве!</span>&nbsp;</strong></div>
<div>(<span>У нас действует бесплатная доставка кофе по Москве при заказе от 1 кг. У нас собственная служба доставки и это гарант того, что жители Москвы получат свои покупки прямо в день заказа или на следующий день в удобное для Вас место и время. Также Вы можете заказать товары на дом курьером, до терминала транспортной компании или до ближайшего почтового отделения).</span></div>
<div><span>Кроме того, вы можете забрать свой заказ из наших кофеен!</span></div>
<div><span></span></div>
<div><span></span></div>
<div><strong><span><span style=\"font-size: 12pt;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Всегда свежий кофе!</span>&nbsp;</span></strong></div>
<div>Кофе &ndash; живой продукт. Он также подвержен старению и окислению. Со временем, ароматные масла и вкусо-ароматические соединения улетучиваются, напиток из старого зерна получается пустой, прогорклый и невкусный. Наш кофе, в отличие от зерна, годами лежащего на полке в супермаркете, всегда свежеобжарен. Для того, чтобы вы пили вкусный (=свежий) кофе, зерно обжаривается по нашему заказу каждую неделю.</div>
<div><span></span></div>
<div><span></span></div>"),
				"rewrite" => "",
				"theme" => "site_start.php",
				"sort" => 1,
			),
			array(
				"id" => 3,
				"sort" => 5,
			),
			array(
				"id" => 2,
				"name" => array("Полезное"),
				"text" => array("<insert name=\"show_links\" module=\"site\">"),
				"rewrite" => "useful",
				"sort" => 5,
			),
			array(
				"id" => 4,
				"name" => array("О нас"),
				"text" => array("<p>Разнообразный и богатый опыт начало повседневной работы по формированию позиции влечет за собой процесс внедрения и модернизации направлений прогрессивного развития. Повседневная практика показывает, что сложившаяся структура организации играет важную роль в формировании направлений прогрессивного развития. Таким образом дальнейшее развитие различных форм деятельности в значительной степени обуславливает создание системы обучения кадров, соответствует насущным потребностям. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности представляет собой интересный эксперимент проверки систем массового участия.</p>
<p>Разнообразный и богатый опыт рамки и место обучения кадров требуют от нас анализа дальнейших направлений развития. Равным образом дальнейшее развитие различных форм деятельности в значительной степени обуславливает создание соответствующий условий активизации. Не следует, однако забывать, что начало повседневной работы по формированию позиции представляет собой интересный эксперимент проверки форм развития. Товарищи! реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании дальнейших направлений развития. Задача организации, в особенности же рамки и место обучения кадров представляет собой интересный эксперимент проверки существенных финансовых и административных условий.</p>"),
				"rewrite" => "o-nas",
				"sort" => 2,
				"menu" => "2",
				"children" => array(
					array(
						"id" => 36,
						"name" => array("Отзывы"),
						"text" => array("<insert name=\"show\" module=\"reviews\">"),
						"rewrite" => "reviews",
						"sort" => 36,
						"menu" => "1",
					),
				),
			),
			array(
				"id" => 20,
				"name" => array("Доставка"),
				"text" => array("<h3>Заказ</h3>
<p>Заказ можно осуществить круглосуточно.</p>
<p>Мы с удовольствием поможем с выбором и проконсультируем по телефону с 09:00 до 18:00 с понедельника по пятницу.</p>
<p>После отправления заказа, с вами обязательно свяжется наш сотрудник для подтверждения заказа. Без подтверждения заказа по телефону, доставка не осуществляется и заказ не формируется! Это важно! Всегда корректно указывайте номер телефона.</p>
<p>Заказы, оформленные до 12:00 доставляются на следующий день. Заказы, оформленные после 12:00 доставляются через 1 день после оформления. </p>
<h3>Оплата</h3>
<p> Оплата наличными производится в пункте самовывоза, либо курьеру при получении заказа.</p>
<h4>Самовывоз</h4>
<p> Забрать заказ, а также попробовать наши напитки вы можете в нашем эспрессо баре по адресу:</p>
<em>м. Электрозаводская, ул. Большая Семеновская, д. 16,</em> 
<p><em>ТЦ \"Серебряный Дом\", 3 этаж, кофейня \"Coffelavka\"</em> c 10:00 до 22:00</p>
<h4><strong>Доставка курьером</strong></h4>
<p> При оформлении заказа укажите желаемые дату и время доставки, мы перезвоним, чтобы подтвердить ваши данные и факт заказа.</p>
<p> Доставка курьером осуществляется на следующий день, по Москве, в пределах МКАД.</p>
<p>с 10:00 до 22:00.</p>
<p>Стоимость доставки: 300 рублей. </p>
<p>Заказ от 5 000 руб. - доставка бесплатная.</p>
<p> Доставка по России возможна через транспортные компании. </p>
<p>Если у вас есть вопросы или пожелания вы можете писать на адрес: info@coffeelavka.ru</p>"),
				"rewrite" => "dostavka",
				"sort" => 21,
				"menu" => "1",
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 28,
				"name" => array("5 пунктов самовывоза"),
				"text" => array("<table width=\"100%\"><caption></caption>
<tbody>
<tr>
<td width=\"70%\" style=\"padding: 5px;\">
<script type=\"text/javascript\" charset=\"utf-8\" src=\"https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=dfcwJRIts_HC5EwR1EgbQ2nfS5RLJSoQ&amp;width=100%&amp;height=320&amp;lang=ru_RU&amp;sourceType=constructor\"></script>
</td>
<td width=\"30%\" style=\"border: 2px solid #ffce00; padding: 5px;\">
<h3><span style=\"color: #0000ff; font-size: 12pt;\">м. Электрозаводская</span></h3>
<h3>ТЦ \"Серебрянный Дом\"</h3>
<h3>Кофейня \"Кофелавка\"</h3>
<p>Большая Семеновская, 16. ТЦ Серебряный дом, 3 этаж (зона фудкорта)&nbsp;<span style=\"text-decoration: underline;\">На следующий день после заказа</span>. Выдача товара: с 10.00 до 22.00</p>
<p><span style=\"color: #ff0000;\">Банковские карты не принимаем.</span></p>
</td>
</tr>
<tr>
<td width=\"70%\" style=\"padding: 5px;\">
<script type=\"text/javascript\" charset=\"utf-8\" src=\"https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=WSD1LQPHwiHZ-Iy2qQBp1si8f8Z7_XOz&amp;width=100%&amp;height=320&amp;lang=ru_RU&amp;sourceType=constructor\"></script>
</td>
<td width=\"30%\" style=\"border: 2px solid #ffce00; padding: 5px;\">
<h3><span style=\"color: #0000ff; font-size: 12pt;\">м. Щелковская</span></h3>
<h3>ТЦ \"Щелково\"</h3>
<h3>Кофейня \"Кофелавка\"</h3>
<p>Щелковское шоссе 100. ТРЦ Щелково, 3 этаж (зона фудкорта) <span style=\"text-decoration: underline;\">Через 2-3 дня</span>. Выдача товара: с 10.00 до 22.00</p>
<p><span style=\"color: #ff0000;\">Банковские карты не принимаем.</span></p>
</td>
</tr>
<tr>
<td width=\"70%\" style=\"padding: 5px;\">
<script type=\"text/javascript\" charset=\"utf-8\" async=\"\" src=\"https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ab0f7e805851323eeeea7dafbca7ca5ca32a6bfa9e350a8acc6222d3f21558e1f&amp;width=100%25&amp;height=320&amp;lang=ru_RU&amp;scroll=true\"></script>
</td>
<td width=\"30%\" style=\"border: 2px solid #ffce00; padding: 5px;\">
<h3><span style=\"color: #0000ff; font-size: 12pt;\">м. Арбатская &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<span style=\"color: #ff0000;\">м. Библиотека им. Ленина</span></span></h3>
<h3>ул. Воздвиженка, дом 9.</h3>
<h3>Кофейня \"Кофелавка\"</h3>
<p>Вход в здание с Крестовоздвиженского переулка. &nbsp;(-1 этаж) На охране сказать, что идете в кофейню.&nbsp;<span style=\"text-decoration: underline;\">Через 2-3 дня</span>. Выдача товара: с 10.00 до 18.00</p>
<p><span style=\"color: #ff0000;\">Банковские карты не принимаем.</span></p>
</td>
</tr>
<tr>
<td width=\"70%\" style=\"padding: 5px;\">
<script type=\"text/javascript\" charset=\"utf-8\" src=\"https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=fGGZsiSRuHWqXgUZ6zER5YUVEh3Tmber&amp;width=669&amp;height=320&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true\"></script>
&gt;</td>
<td width=\"30%\" style=\"border: 2px solid #ffce00; padding: 5px;\">
<h3><span style=\"font-size: 12pt;\"><span style=\"color: #ff9900;\">м. Новокосино &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style=\"color: #ff9900;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; м. Новогиреево</span></span></h3>
<h3>ТЦ \"Шоколад\"</h3>
<h3>Кофейня \"Кофелавка\"</h3>
<p>г. Реутов 2 км МКАД (внешняя сторона) 4 этаж (зона фудкорта)&nbsp;<span style=\"text-decoration: underline;\">Через 2-3 дня</span><span>.</span>. Выдача товара: с 10.00 до 22.00</p>
<p><span style=\"color: #008000;\">Возможна оплата банковскими картами</span></p>
</td>
</tr>
<tr>
<td width=\"70%\" style=\"padding: 5px;\">
<script type=\"text/javascript\" charset=\"utf-8\" src=\"https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=4n2RyU33JnD2nHgJ79qPnEnaRolrgFC8&amp;width=100%&amp;height=320&amp;lang=ru_RU&amp;sourceType=constructor\"></script>
</td>
<td width=\"30%\" style=\"border: 2px solid #ffce00; padding: 5px;\">
<h3><span style=\"color: #0000ff; font-size: 12pt;\">м. Электрозаводская</span></h3>
<h3>БЦ \"Мега Экспо\"</h3>
<h3>Склад \"Кофелавки\"</h3>
<p>площадь Журавлева, 10. Бизнес центр \"Мега-Экспо\", офис 206. Время работы: 10.00 - 18.00 с ПН по ПТ. Заходите к нам! угостим чашечкой кофе и познакомим со всем нашим товаром:)</p>
<p><span style=\"color: #008000;\">Возможна оплата банковскими картами</span></p>
</td>
</tr>
</tbody>
</table>"),
				"rewrite" => "punkty-samovyvoza",
				"sort" => 28,
				"menu" => "1",
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 29,
				"name" => array("Шоу рум"),
				"rewrite" => "shou-rum",
				"sort" => 29,
			),
			array(
				"id" => 31,
				"name" => array("Услуги"),
				"rewrite" => "uslugi",
				"sort" => 31,
			),
			array(
				"id" => 32,
				"name" => array("Заказ оформлен"),
				"text" => array("<h1>Вы великолепны! Мы вскоре свяжемся с вами</h1>"),
				"rewrite" => "zakaz-oformlen",
				"sort" => 32,
			),
			array(
				"id" => 33,
				"name" => array("Оплата"),
				"text" => array("<iframe frameborder=\"0\" allowtransparency=\"true\" scrolling=\"no\" src=\"https://money.yandex.ru/embed/shop.xml?account=410012083493965&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=%D0%BE%D0%BF%D0%BB%D0%B0%D1%82%D0%B0+%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7%D0%B0&default-sum=&button-text=01&comment=on&hint=%D0%BD%D0%BE%D0%BC%D0%B5%D1%80+%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7%D0%B0&successURL=http%3A%2F%2Fcoffeelavka.ru%2F\" width=\"450\" height=\"268\"></iframe>"),
				"rewrite" => "oplata",
				"sort" => 33,
				"menu" => array("5", "1"),
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 34,
				"name" => array("Вакансии"),
				"text" => array("<p><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\"><img src=\"BASE_PATHuserfiles/editor/medium/182_logo.jpg\" alt=\"\" title=\"\" width=\"281\" height=\"72\"></span></p>
<p><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">В мини-кофейню Coffeelavka на постоянную занятость требуется бариста (вакансия в г. Реутов, ТЦ Шоколад). </span></p>
<p><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">З/п от 30 000 - 45000 руб.</span></p>
<p><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">Требования:</span><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">- ответственность;</span><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">- дружелюбие;</span><span><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">- активность;</span><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">- опрятный внешний вид;</span><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">- грамотная речь;</span><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">- искреннее желание изучать кофейную культуру и дарить радость людям!</span><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">- желателен опыт работы в сфере обслуживания.</span></span></p>
<p><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">Возможно, мы ищем именно тебя, а ты - именно нас :)</span></p>
<p><span><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">График работы сменный (2/2 или по договоренности, не менее 15 смен в месяц), смены по 12 часов.</span><br><br><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\">По вопросам и для записи на собеседование звоните строго с 10.00 до 20.00 по тел. +7&nbsp;929 597 88 70 Артем</span><br></span></p>
<p><span><span style=\"font-family: 'book antiqua', palatino, serif; font-size: 12pt;\"><img src=\"BASE_PATHuserfiles/editor/medium/181_barista_twitter2_400x400.png\" alt=\"\" title=\"rosetta\" width=\"300\" height=\"300\"></span></span></p>"),
				"rewrite" => "vakansii",
				"sort" => 34,
				"menu" => "5",
			),
		),
		"site_blocks" => array(
			array(
				"id" => 1,
				"name" => array("Телефон в шапке сайта"),
				"text" => array("+7 495 220 98 15"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 2,
				"name" => array("Контакты в футере"),
				"text" => array("<p class=\"text-muted h6\">Москва, площадь Журавлева, 10, офис 206.</p>
<p class=\"text-muted h6\">+7 495 220 98 15</p>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 3,
				"name" => array("Блок о доставке в карточке товара"),
				"text" => array("<p>Доставка курьером в пред. МКАД</p>
<p>До ТК СДЭК - бесплатно от 2000 руб.</p>
<p>По Москве - 300 руб.</p>
<p>Заказ от 1кг кофе - бесплатно.</p>
<p></p>"),
				"title_no_show" => "1",
				"rel" => 0,
			),
			array(
				"id" => 4,
				"name" => array("Блок о возврате в карточке товара"),
				"text" => array("<p><span>Если вам не понравился наш товар - мы вернём вам деньги.</span></p>"),
				"title_no_show" => "1",
				"rel" => 0,
			),
			array(
				"id" => 5,
				"name" => array("Режим работы"),
				"text" => array("<b>Пн-Пт:</b><br> c 9:00 до 18:00"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 6,
				"name" => array("Соц сети в подвале"),
				"text" => array("<a href=\"https://www.facebook.com/Coffee-Lavka-387159624743345/ \">
 	<span class=\"fa-stack fa-lg\">
 		<i class=\"fa fa-facebook fa-stack-1x fa-inverse\"></i>
 	</span>
 </a>
 <a href=\"https://vk.com/coffeelavka\">
 	<span class=\"fa-stack fa-lg\">
 		<i class=\"fa fa-vk fa-stack-1x fa-inverse\"></i>
 	</span>
 </a>
 <a href=\"https://www.instagram.com/coffeelavka_msk/\">
 	<span class=\"fa-stack fa-lg\">
 		<i class=\"fa fa-instagram fa-stack-1x fa-inverse\"></i>
 	</span>
 </a>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 7,
				"name" => array("Разработка сайтов"),
				"text" => array("<div style=\"text-align: right;\"><a title=\"продвигает сайт\" href=\"http://www.pavelbogdanov.com/\" target=\"_blank\">Павел Богданов</a></div>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
		),
	);
}