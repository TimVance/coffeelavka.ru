UPDATE {site} SET `theme`='site_start.php', [name]='ПОЧЕМУ У НАС ЛУЧШИЙ КОФЕ?', [text]='<div><span style="font-size: 14pt;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></div>
<div></div>
<div><span style="font-size: 12pt;"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Мы продаем фермерский кофе!</strong></span></div>
<div>Фермерский кофе -&nbsp;особый, такого не найдешь в супермаркетах! Мы продаем только высокогорную 100% арабику. Некоторые&nbsp; сорта можно проследить от конкретной фермы и её владельца, где бережно выращиваются, собираются и обрабатываются кофейные ягоды, до прилавка кофейни. Весь наш кофе выращен без применения вредных химических веществ, он экологически чистый, отборный и очень вкусный.&nbsp;В ассортименте есть&nbsp;уникальные лоты, которые&nbsp; представляют собой результаты совместных экспериментов обжарщика и фермера. Попробуйте продукт, созданный влюбленными в своё дело людьми!&nbsp;</div>
<div></div>
<div><strong><span style="font-size: 12pt;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Лучшие обжарщики Москвы!</span> </strong></div>
<div>Обжарка в мире производителей кофе не зря именуется магией: после обжарки до 30% веса зерна составляют новые вещества и соединения. Какими они будут, получится ли раскрыть потенциал высокогорной арабики в чашке &ndash; во многом зависит от качества оборудования и профессионализма обжарщика. Наш обжарщик входит в 10-ку лучших в мире, работает на первоклассном оборудовании с отобранными на фермах лучшими сортами арабики. Обжарка производится каждую неделю &ndash; это гарантия свежести и вкуса!</div>
<div></div>
<div></div>
<div><strong><span style="font-size: 12pt;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Самая Быстрая доставка кофе в Москве!</span>&nbsp;</strong></div>
<div>(<span>У нас действует бесплатная доставка кофе по Москве при заказе от 1 кг. У нас собственная служба доставки и это гарант того, что жители Москвы получат свои покупки прямо в день заказа или на следующий день в удобное для Вас место и время. Также Вы можете заказать товары на дом курьером, до терминала транспортной компании или до ближайшего почтового отделения).</span></div>
<div><span>Кроме того, вы можете забрать свой заказ из наших кофеен!</span></div>
<div><span></span></div>
<div><span></span></div>
<div><strong><span><span style="font-size: 12pt;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Всегда свежий кофе!</span>&nbsp;</span></strong></div>
<div>Кофе &ndash; живой продукт. Он также подвержен старению и окислению. Со временем, ароматные масла и вкусо-ароматические соединения улетучиваются, напиток из старого зерна получается пустой, прогорклый и невкусный. Наш кофе, в отличие от зерна, годами лежащего на полке в супермаркете, всегда свежеобжарен. Для того, чтобы вы пили вкусный (=свежий) кофе, зерно обжаривается по нашему заказу каждую неделю.</div>
<div><span></span></div>
<div><span></span></div>' WHERE id=1;
INSERT IGNORE INTO {site_blocks} (`id`) VALUES (1),(2),(3),(4),(5),(6),(7);
UPDATE {site_blocks} SET [name]='Телефон в шапке сайта', [text]='+7 495 220 98 15', [act]='1', title_no_show='1' WHERE id=1;
UPDATE {site_blocks} SET [name]='Контакты в футере', [text]='<p class="text-muted h6">Москва, площадь Журавлева, 10, офис 206.</p>
<p class="text-muted h6">+7 495 220 98 15</p>', [act]='1', title_no_show='1' WHERE id=2;
UPDATE {site_blocks} SET [name]='Блок о доставке в карточке товара', [text]='<p>Доставка курьером в пред. МКАД</p>
<p>До ТК СДЭК - бесплатно от 2000 руб.</p>
<p>По Москве - 300 руб.</p>
<p>Заказ от 1кг кофе - бесплатно.</p>
<p></p>', [act]='1', title_no_show='1' WHERE id=3;
UPDATE {site_blocks} SET [name]='Блок о возврате в карточке товара', [text]='<p><span>Если вам не понравился наш товар - мы вернём вам деньги.</span></p>', [act]='1', title_no_show='1' WHERE id=4;
UPDATE {site_blocks} SET [name]='Режим работы', [text]='<b>Пн-Пт:</b><br> c 9:00 до 18:00', [act]='1', title_no_show='1' WHERE id=5;
UPDATE {site_blocks} SET [name]='Соц сети в подвале', [text]='<a href="https://www.facebook.com/Coffee-Lavka-387159624743345/ ">
 	<span class="fa-stack fa-lg">
 		<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
 	</span>
 </a>
 <a href="https://vk.com/coffeelavka">
 	<span class="fa-stack fa-lg">
 		<i class="fa fa-vk fa-stack-1x fa-inverse"></i>
 	</span>
 </a>
 <a href="https://www.instagram.com/coffeelavka_msk/">
 	<span class="fa-stack fa-lg">
 		<i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
 	</span>
 </a>', [act]='1', title_no_show='1' WHERE id=6;
UPDATE {site_blocks} SET [name]='Разработка сайтов', [text]='<div style="text-align: right;"><a title="продвигает сайт" href="http://www.pavelbogdanov.com/" target="_blank">Павел Богданов</a></div>', [act]='1', title_no_show='1' WHERE id=7;
DELETE FROM {site_blocks_site_rel};
INSERT IGNORE INTO {site_blocks_site_rel} (`element_id`,`site_id`) VALUES (6,0);
INSERT IGNORE INTO {site_blocks_site_rel} (`element_id`,`site_id`) VALUES (4,0);
INSERT IGNORE INTO {site_blocks_site_rel} (`element_id`,`site_id`) VALUES (7,0);
INSERT IGNORE INTO {site_blocks_site_rel} (`element_id`,`site_id`) VALUES (5,0);
INSERT IGNORE INTO {site_blocks_site_rel} (`element_id`,`site_id`) VALUES (2,0);
INSERT IGNORE INTO {site_blocks_site_rel} (`element_id`,`site_id`) VALUES (1,0);
INSERT IGNORE INTO {site_blocks_site_rel} (`element_id`,`site_id`) VALUES (3,0);
INSERT IGNORE INTO {menu_category} (`id`) VALUES (1),(2),(3),(5),(6);
UPDATE {menu_category} SET [name]='Меню верхнее', [act]='1' WHERE id=1;
UPDATE {menu_category} SET [name]='Меню интернет-магазин', [act]='1' WHERE id=2;
UPDATE {menu_category} SET [name]='Наши товары', [act]='1' WHERE id=3;
UPDATE {menu_category} SET [name]='Меню пользователя', [act]='1' WHERE id=5;
UPDATE {menu_category} SET [name]='Категории новостей', [act]='1' WHERE id=6;
DELETE FROM {menu_category_site_rel};
INSERT IGNORE INTO {menu_category_site_rel} (`element_id`) VALUES (1),(2),(3),(5),(6);
INSERT IGNORE INTO {bs_category} (`id`) VALUES ();
