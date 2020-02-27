<div id="top_block" style="background-color: green; color: #fff;">
	<div class="container">
		<insert name="show_block" module="site" id="9">
	</div>
</div>
<div class="head-line">
	<nav class="navbar navbar-default navbar-top">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button style="background:#FFCE00;margin-left:5px;margin-right: 20px;" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
<!--					<div class="navbar-search logo-img-m hidden-lg hidden-md hidden-sm"> -->
<!--						<a  href="/"><img class="img-responsive" src="<insert name="path">custom/my/img/logo_img.png" alt=""></a>-->
<!--					</div>-->
					<div class="navbar-search hidden-lg hidden-md hidden-sm" style="margin-right:5px;">
						<a href="/"><img style="height:36px;" class="img-responsive" src="<insert name="path">custom/my/img/logo-coffelavka.svg" alt=""></a>
					</div>
			<div class="navbar-phone" style="margin-top:5px;"><a style="padding:0;" href="tel:+74952209815"><i style="font-size: 18px;" class="fa fa-phone" aria-hidden="true"></i></a></div>					
			<div class="navbar-search" style="margin-top:5px;"><button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3" aria-expanded="false"><i class="fa fa-search" aria-hidden="true" style="font-size: 18px;" ></i></button></div>




			<div class="navbar-cart" style="width:auto;"><insert name="show_block" module="cart"></div>
			<div class="navbar-search hidden-lg hidden-md hidden-sm" style="width:auto;margin-left:5px;"><a href="/user/avtorizatsiya/"><i  style="font-size: 18px;margin-top:5px;" class="fa fa-user" aria-hidden="true"></a></i></div>
			<div class="navbar-header cat_nav hidden-xs">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
				<insert name="show_block" module="menu" id="1" template="topmenu">
				<a class="hidden-lg hidden-md hidden-sm" href="/user/avtorizatsiya/">Вход и регистрация</a>
								<div class="dropdown show call_back hidden-lg hidden-md hidden-sm" style="height:35px;margin:10px 0;">
					<a class="bdropdown-toggle main-link mobile-call-back" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				   	Обратный звонок
				   </a>
				</div>
				<ul class="nav navbar-nav ">
					<li>
						<insert name="show_block" module="wishlist">
					</li>
				</ul>
			
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<div class="hidden-lg hidden-md hidden-sm"><insert name="show_block" module="menu" id="2" template="cat">
				
				</div>

			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
				<div class="hidden-lg hidden-md hidden-sm"><insert name="show_search" module="search" button="найти" template="top"></div>
			</div>
		</div>
	</nav>
</div>
<header class="header">
	<div class="container">
		<div class="row">
			<div class="col-sm-5 col-md-4">
				<div class="logo hidden-xs">
					<!--a href="/"><img class="img-responsive" src="<insert name="path">custom/my/img/logo.png" alt=""></a-->
<!--					<div class="pull-left">-->
<!--						<a href="/"><img class="img-responsive" src="<insert name="path">custom/my/img/logo_img.png" alt=""></a>-->
<!--					</div>-->

					<a href="/"><img class="img-responsive" src="<insert name="path">custom/my/img/logo-coffelavka.svg" alt=""></a>

				</div>

			</div>
			<div class="col-sm-4 col-md-3 hidden-md hidden-xs">
				<div class="phone">
					<insert name="show_block" module="site" id="1">
				</div>
				<!--div class="call_back">
					<a class="main-link" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" href="#">обратный звонок</a>
				</div-->
				<!--div class="dropdown-menu panel-body">
					<insert name="show_form" module="feedback" site_id="35">
			    </div-->
				<div class="dropdown show call_back">
					<a class="bdropdown-toggle main-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				   	обратный звонок
				   </a>
				</div>
			</div>
			<div class="hidden-sm col-md-2 hidden-md hidden-xs">
				<div class="time-work">
					<div class="time-clock"> <insert name="show_block" module="site" id="5"></div>
				</div>
			</div>
			<div class="col-sm-3 col-md-3 hidden-xs">
				<insert name="show_block" module="cart">
			</div>
		</div>
	</div>
</header>
<div class="main-nav hidden-xs">
<div class="container">
	<nav class="navbar navbar-default">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<!--insert name="show_block" module="menu" id="2" template="cat"-->
			<insert name="show_block" module="menu" id="2" template="topmenu">
			<insert name="show_search" module="search" button="найти" template="top">
		</div>
	</nav>

	</div>
</div>
	<div class="container">
		<!--ul class="nav nav-pills "><insert name="show_block" module="menu" id="8" tag_start_1="[li class=categoryIncrement]" tag_end_1="[/li]"></ul-->
	</div>