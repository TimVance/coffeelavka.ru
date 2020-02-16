<?php
/**
 * Шаблон стартовой страницы сайта
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

if(! defined("DIAFAN"))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}
?><!doctype html>
<html>
<head>
	<insert name="show_include" file="head">
	
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '289602335231970'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=289602335231970&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

<meta name="yandex-verification" content="4e3b07815b8bb3a6" />
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
</head>
<body>
	<div class="main">
		<insert name="show_block" module="example">
	
		<insert name="show_include" file="header">

			<div class="slides">
				<div class="container">
				<!-- <div id="owl-demo" class="owl-carousel owl-theme">

					<div class="item">
						<img src="/custom/flowers/img/sl1.jpg" class="img-responsive" alt="The Last of us"></div>
					<div class="item">
						<img src="/custom/flowers/img/sl2.jpg" class="img-responsive" alt="GTA V"></div>
					<div class="item">
						<img src="/custom/flowers/img/sl1.jpg" class="img-responsive"alt="Mirror Edge"></div>
20.7%
				</div> -->
				<!--insert name="show_block" module="bs" sort="rand" template="slider" count="3"-->
				<insert name="show_block" module="bs" sort="rand" template="slider" count="all">

				<!-- <div class="jumbotron">
				<h1>Добро пожаловать!</h1>
				<p>
					<br></p>
				<p>
					<a class="btn btn-danger" href="#" role="button">Узнать больше</a>
				</p>
			</div>
			-->
			</div>
		</div>
	
<!-- блок категорий главной страницы -->
		<div class="content">
			<div class="container 557">

<insert name="show_block" module="menu" id="8" template="supermenu">			
			
				<!--div id="cat_prod">
					<div id="prod_left">
						<div id="coffe">
							<a href="/shop/svezheobzharennyy-kofe-v-zernakh/">
								<img src="<insert name="path">custom/my/img/coffeee.png" alt="">
								<span>КОФЕ<br/> В ЗЕРНАХ</span>
							</a>
						</div>
						<div id="tea_list">
							<a href="/shop/listovoy-chay/">
								<img src="<insert name="path">custom/my/img/tea_list.png" alt="">
								<span>ЧАЙ<br/> ЛИСТОВОЙ</span>
							</a>
						</div>
					</div>
					<div id="prod_right">
						<div class="line1">
							<div id="oborud">
								<a href="/shop/tovary-dlya-barista/">
									<img src="<insert name="path">custom/my/img/oborud.png" alt="">
									<span>УХОД ЗА<br/> ОБОРУДОВАНИЕМ</span>
								</a>
							</div>
							<div id="chock">
								<a href="/shop/shokolad-na-medu/">
									<img src="<insert name="path">custom/my/img/chock.png" alt="">
									<span>ШОКОЛАД И КАКАО</span>
								</a>
							</div>
							<div id="matcha">
								<a href="/shop/listovoy-chay/japonskij-chay/">
									<img src="<insert name="path">custom/my/img/tea_j.png" alt="">
									<span>ЯПОНСКИЙ ЧАЙ<br/> МАТЧА</span>
								</a>
							</div>
						</div>
						<div class="line2">
							<div id="akses">
								<a href="/shop/aksessuary/">
									<img src="<insert name="path">custom/my/img/akses.png" alt="">
									<span>АКСЕССУАРЫ</span>
								</a>
							</div>							
							<div id="rio">
								<a href="/shop/pryanyy-chay-latte-david-rio-chai/">
									<img src="<insert name="path">custom/my/img/rio.png" alt="">
									<span>ПРЯНЫЙ ЧАЙ<br/>
			 						DAVID RIO</span>
		 						</a>
							</div>
						</div>
						<div class="line3">
							<div id="djez">
								<a href="/shop/aksessuary/dzhezvy-turki/">
									<img src="<insert name="path">custom/my/img/djez.png" alt="">
									<span>ДЖЕЗВЫ</span>
								</a>
							</div>
							<div id="sirop">
								<a href="/shop/siropy/">
									<img src="<insert name="path">custom/my/img/sirop.png" alt="">
									<span>СИРОПЫ</span>
								</a>
							</div>
						</div>
					</div>
				</div-->
<!-- категории для мобильной версии -->
				<div id="mob">
					<div id="mob_prod">
						<div class="line1">
							<div id="rio">
								<a href="/shop/pryanyy-chay-latte-david-rio-chai/">
									<img src="<insert name="path">custom/my/img/mob_rio.png" alt="">
									<span>ПРЯНЫЙ ЧАЙ<br/>
			 						DAVID RIO</span>
		 						</a>
							</div>	
							<div id="tea_list">
								<a href="/shop/listovoy-chay/">
									<img src="<insert name="path">custom/my/img/mob_tea_list.png" alt="">
									<span>ЧАЙ</span>
								</a>
							</div>		
						</div>
						<div class="line2">
							<div class="line2_left">
								<div id="coffe">
									<a href="/shop/svezheobzharennyy-kofe-v-zernakh/">
										<img src="<insert name="path">custom/my/img/mob_coffe.png" alt="">
										<span>КОФЕ<br/> В ЗЕРНАХ</span>
									</a>
								</div>
								<div id="chock">
									<a href="/shop/shokolad-na-medu/">
										<img src="<insert name="path">custom/my/img/mob_chock.png" alt="">
										<span>ШОКОЛАД И КАКАО</span>
									</a>
								</div>
							</div>
							<div class="line2_right">
								<div id="matcha">
									<a href="/shop/listovoy-chay/japonskij-chay/">
										<img src="<insert name="path">custom/my/img/mob_tea_j.png" alt="">
										<span>ЯПОНСКИЙ ЧАЙ<br/> МАТЧА</span>
									</a>
								</div>
								<div id="akses">
									<a href="/shop/aksessuary/">
										<img src="<insert name="path">custom/my/img/mob_akses.png" alt="">
										<span>АКСЕССУАРЫ</span>
									</a>
								</div>
								<div id="oborud">
									<a href="/shop/tovary-dlya-barista/">
										<img src="<insert name="path">custom/my/img/mob_oborud.png" alt="">
										<span>УХОД<br/> ЗА ОБОРУДОВАНИЕМ</span>
									</a>
								</div>
							</div>
						</div>	
						<div class="line3">
							<div id="djez">
								<a href="/shop/aksessuary/dzhezvy-turki/">
									<img src="<insert name="path">custom/my/img/mob_djez.png" alt="">
									<span>ДЖЕЗВЫ</span>
								</a>
							</div>
							<div id="sirop">
								<a href="/shop/siropy/">
									<img src="<insert name="path">custom/my/img/mob_sirop.png" alt="">
									<span>СИРОПЫ</span>
								</a>
							</div>
						</div>					
					</div>		
				</div>
			</div>
		</div>
<!-- конец блока категорий главной страницы -->

		<div class="content">
			<div class="container">
				<h3>
					Акция
				</h3>
				<div id="owl-demo1" class=" text-center">
					<insert name="show_block" module="shop" count="5" action_only="true" images="1">
				</div>
				<hr>
				<h3 class="">
					Популярные товары
				</h3>

				<div id="owl-demo2" class=" text-center">
					<insert name="show_block" module="shop" count="5" hits_only="true" images="1">
				</div>
				<hr>
				<h3>
					Новинки
				</h3>
				<div id="owl-demo3" class=" text-center">
					<insert name="show_block" module="shop" count="5" new_only ="true" images="1">
				</div>
			</div>
		</div>
		<div class="container">
		<hr>
			<div class="about-as">
				<!--h2 class="text-center"><insert name="show_h1"></h2-->
				<h1 class="text-center"><insert name="show_h1"></h1>
				<p>
					<insert name="show_text">
				</p>
			</div>
		<hr>
		</div>
		<!--div class="news">
			<div class="container">
				<div class=" text-left">
					<insert name="show_block" module="news" count="3"  site_id="5"  images_variation="large">
				</div>
		</div>
	</div-->
	<!-- Адаптивный режим -->
	
	<!--iframe src='/inwidget/index.php?adaptive=true' data-inwidget scrolling='no' frameborder='no' style='border:none;width:100%;height:315px;overflow:hidden;'></iframe-->
<div class="container">

<!--div class="instagram-logo">
<img src="img/instagram-logo.jpg" alt="">
</div-->
<br/>
<div class="logo_bottom">
	<div class="pull-left">
	<!--img src="<insert name="path">custom/my/img/logo_img.png" alt=""-->
	<img src="img/instagram-logo.jpg" alt="">
	<!--span class="inst_text">	
		coffeelavka_ru
	</span-->
	<span class="hidden-xs">
		<!--a href="https://www.instagram.com/coffeelavka_ru/" class="subscribe-button" target="_blank" rel="nofollow">Подписаться</a-->
		<a href="https://www.instagram.com/coffeelavka_online/" class="subscribe-button" target="_blank" rel="nofollow">Подписаться</a>
	</span>
	<div class="hidden-sm hidden-md hidden-lg subscribe_m">
		<!--a href="https://www.instagram.com/coffeelavka_ru/" class="subscribe-button" target="_blank" rel="nofollow">Подписаться</a-->
		<a href="https://www.instagram.com/coffeelavka_online/" class="subscribe-button" target="_blank" rel="nofollow">Подписаться</a>
	</div>
	</div>
	<div class="pull-right hidden-xs">
		<!--a href="https://www.instagram.com/coffeelavka_ru/" class="more-insta" target="_blank" rel="nofollow">Смотреть всю ленту</a-->
		<a href="https://www.instagram.com/coffeelavka_online/" class="more-insta" target="_blank" rel="nofollow">Смотреть всю ленту</a>
	</div>
	<div class="hidden-sm hidden-md hidden-lg look_all">
		<!--a href="https://www.instagram.com/coffeelavka_ru/" class="more-insta" target="_blank" rel="nofollow">Смотреть всю ленту</a-->
		<a href="https://www.instagram.com/coffeelavka_online/" class="more-insta" target="_blank" rel="nofollow">Смотреть всю ленту</a>
	</div>
</div>

    <!-- LightWidget WIDGET --><script src="https://cdn.lightwidget.com/widgets/lightwidget.js"></script><iframe src="https://cdn.lightwidget.com/widgets/4fbf262543835b968c8d0cdd15d21b21.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width:100%;border:0;overflow:hidden;"></iframe>

</div>
	<insert name="show_include" file="footer">


<!--insert name="show_block" module="menu" id="2"-->
