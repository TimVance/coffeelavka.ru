<footer class="footer">
	<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h4>
						<strong>Способы оплаты</strong>
					</h4>
					<img src="<insert name="path">custom/my/img/buyicon.png" alt="">
				</div>
				<div class="col-md-5">
					<h4>
						<strong>Контакты</strong>
						<p class="text-muted h6">
							<insert name="show_block" module="site" id="2">
						</p>
					</h4>
				</div>
				<div class="col-md-3">
					<h4>
						<strong>Мы в соц сетях</strong>
					</h4>
					<div>
						<insert name="show_block" module="site" id="6">
					</div>
				</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<p class="text-muted 333"><insert name="show_year" year="2015"></p>
			</div>
			<div class="col-md-9">
				<!--ul class="nav nav-pills ">
				<insert name="show_block" module="menu" id="1" tag_start_1="[li]" tag_end_1="[/li]">
				</ul-->
				<ul class="nav nav-pills "><insert name="show_block" module="menu" id="7" tag_start_1="[li]" tag_end_1="[/li]"></ul>
			</div>
			<!--div class="col-md-3">
				<p class="text-muted">
					<insert name="show_block" module="site" id="7">
				</p>
			</div-->
		</div>
	</div>
</footer>
</div>
<div class="bgmodal"></div>
<insert name="show_form" module="feedback" site_id="35">
<insert name="show_privacy" hash="false" text="">
<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter34974455 = new Ya.Metrika({ id:34974455, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true, ut:"noindex" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/34974455?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

<insert name="show_js">
<script type="text/javascript" src="<insert name="path">custom/my/js/bootstrap.min.js"></script>
<script src="<insert name="path">custom/my/js/owl.carousel.min.js"></script>
<script src="<insert name="path">custom/my/js/scrollto.js"></script>
<script src="<insert name="path">custom/my/js/main.js"></script>
<script src="<insert name="path">custom/my/js/jquery.growl.js"></script>
<script src="<insert name="path">custom/my/js/simple.js"></script>
<!--script src="<insert name="path">custom/my/js/jquery.kladr.min.js"></script-->
<!--script src="<insert name="path">custom/my/js/kladr.js"></script-->
<!--script src="<insert name="path">custom/my/js/lib/jquery-1.11.1.min.js"></script-->
<!--script src="<insert name="path">custom/my/js/lib/jquery-1.11.1.min.map"></script-->
<script language="javascript" type="text/javascript">
    function setCookie(name, value, options = {}) {

        options = {
            path: '/',
        };

        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }

        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    }
    function privacy_close() {
        setCookie("privacy_close", "true", {secure: true, 'max-age': 1209600});
        $(".privacy_policy").remove();
    }
    $(function() {
        $(".call_back.show, .mobile-call-back").click(function() {
            $(".modal-feedback_form, .bgmodal").fadeIn();
        });
        $(".bgmodal, .closedmodal").click(function () {
            $(".modal-feedback_form, .bgmodal").fadeOut();
        });
    });
</script>
</body>
</html>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter47534170 = new Ya.Metrika2({ id:47534170, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/47534170" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<script>
    (function(w,d,u){
        var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
        var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
    })(window,document,'https://cdn-ru.bitrix24.ru/b13036432/crm/site_button/loader_2_t4vp1g.js');
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


