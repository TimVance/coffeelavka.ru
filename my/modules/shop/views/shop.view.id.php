<?php
/**
 * Шаблон страницы товара
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

echo '<div class=" js_shop_id js_shop shop shop_id shop-item-container">';


echo '<div class="col-md-6 produc-img">';

//вывод изображений товара
if (!empty($result["img"]))
{
	echo '<div id="sync1" class="owl-carousel">';
	$k = 0;
	foreach ($result["img"] as $img)
	{
		switch ($img["type"])
		{
			case 'animation':
				echo '<a class="js_shop_img shop-item-image'.(empty($k) ? ' active' : '').'" href="'.BASE_PATH.$img["link"].'" data-fancybox="gallery" style="background-image:url('.BASE_PATH.$img["link"].')" image_id="'.$img["id"].'">';
				break;
			case 'large_image':
				echo '<a class="js_shop_img shop-item-image'.(empty($k) ? ' active' : '').'" href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'" style="background-image:url('.BASE_PATH.$img["link"].')" image_id="'.$img["id"].'">';
				break;
			default:
				echo '<a class="js_shop_img shop-item-image'.(empty($k) ? ' active' : '').'" href="'.BASE_PATH.$img["link"].'" style="background-image:url('.BASE_PATH_HREF.$img["link"].')" image_id="'.$img["id"].'">';
				break;
		}
		echo '<div class="item"><img src="'.BASE_PATH.$img["link"].'" alt="'.$img["alt"].'" title="'.$img["title"].'" image_id="'.$img["id"].'" class="img-responsive"></div>';
		echo '</a>';
		$k++;
	}



		echo '</div>';

		echo '<span class="label label-dynamic dynamic">';
		echo $this->htmleditor('<insert name="show_dynamic" module="site" id="3" module_name="shop" element_id="'.$row['id'].'" element_type="element">');
		echo '</span>';

		if (!empty($result['hit']))
		{
			echo '<span class="label label-info hits">ХИТ</span>';
		}
		if (!empty($result['action']))
		{
			echo '<span class="label label-warning actions">АКЦИЯ</span>';
		}
		if (!empty($result['new']))
		{
			echo '<span class="label label-danger newanka">НОВИНКА</span>';
		}






	if($result["preview_images"])
	{
		echo '<div id="sync2" class="owl-carousel">';
		foreach ($result["img"] as $img)
		{
			echo '<div class="item"> <a class="" href="#"><img image_id="'.$img["id"].'" src="'.$img["preview"].'" alt=""></a></div>';
		}
		echo '</div>';
	}

}

echo '</div>';

echo '<div class="col-md-6 description-product">';
	echo '<div class="shop-item-info1">';






		//краткое описание товара
		if (!empty($result["anons"]))
		{
		echo '<div class="shop_text">'.$this->htmleditor($result['anons']).'</div>';
		}

		//параметры товара
		if (!empty($result["param"]))
		{
			echo '<hr>'.$this->get('param', 'shop', array("rows" => $result["param"], "id" => $result["id"])).'<hr>';
		}


		//вывод артикула
		if (!empty($result["article"]))
		{
			echo '<h4 class="shop-item-artikul">'.$this->diafan->_('Артикул').': '.$result["article"].'</h4><hr>';
		}

		//вывод производителя
		if (!empty($result["brand"]))
		{
			echo '<div class="shop_brand">';
			echo $this->diafan->_('<b>Производитель</b>').': ';
			echo '<a href="'.BASE_PATH_HREF.$result["brand"]["link"].'">'.$result["brand"]["name"].'</a>';
			echo '</div><br>';
		}

		//вывод рейтинга товара
		if (!empty($result["rating"]))
		{
			echo '<div class="shop-item-rate rate">'.$this->diafan->_('Рейтинг').": ";
			echo $result["rating"];
			echo '</div>';
		}

		//скидка на товар
		if (!empty($result["discount"]))
		{
			echo '<div class="shop_discount">'.$this->diafan->_('Скидка').': <span class="shop_discount_value">'.$result["discount"].' '.$result["discount_currency"].($result["discount_finish"] ? ' ('.$this->diafan->_('до').' '.$result["discount_finish"].')' : '').'</span></div>';
		}

		//кнопка "Купить"
		echo $this->get('buy_form_id', 'shop', array("row" => $result, "result" => $result));

        echo $this->htmleditor('<insert name="show_social_links">');
        echo '<div class="btn-group wishlist-buttons">
                <a class="js_shop_wishlist shop_wishlist shop-like'.(! empty($result["wish"]) ? ' active' : '').'" >
                    <i class="fa fa-heart"></i> Добавить в избранное
                </a>
              </div>
              <hr>
            ';

	echo '</div>';

	echo '<div class="row">
			<div class="col-md-6">
				<h4><img src="'.BASE_PATH.Custom::path('img/icon_deliver.png').'">'.$this->diafan->_('Условия доставки').'</h4>
				'.$this->htmleditor('<insert name="show_block" module="site" id="3">').'
				</div>
			<div class="col-md-6">
				<h4><img src="'.BASE_PATH.Custom::path('img/icon_return.png').'">'.$this->diafan->_('Условия возврата').'</h4>
				'.$this->htmleditor('<insert name="show_block" module="site" id="4">').'
			</div>
		</div>';



echo '</div></div>';



echo '<div class="row"><div class="col-md-12">';
//счетчик просмотров
if(! empty($result["counter"]))
{
	echo '<div class="shop_counter">'.$this->diafan->_('Просмотров').': '.$result["counter"].'</div>';
}

//теги товара
if (!empty($result["tags"]))
{
	echo $result["tags"];
}
echo '</div></div>';

echo '<div class=" tabrow">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Описание</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Отзывы</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">';
		//полное описание товара
		echo ''.$this->htmleditor($result['text']).'';
    echo '</div>
    <div role="tabpanel" class="tab-pane body" id="profile">';
		//комментарии к товару
		if (!empty($result["comments"]))
		{
			echo $result["comments"];
		}
    echo '</div>
  </div>

</div>';






//полное описание товара
// echo '<div class="shop_text">'.$this->htmleditor($result['text']).'</div>';

echo $this->htmleditor('<insert name="show_block_order_rel" module="shop" count="3" images="1">');

echo $this->htmleditor('<insert name="show_block_rel" module="shop" count="4" images="1">');









//ссылки на предыдущий и последующий товар
if (! empty($result["previous"]) || ! empty($result["next"]))
{
	echo '<ul class="pager">';
	if (! empty($result["previous"]))
	{
		echo '<li class="previous"><a href="'.BASE_PATH_HREF.$result["previous"]["link"].'">&larr; '.$result["previous"]["text"].'</a></li>';
	}
	if (! empty($result["next"]))
	{
		echo '<li class="next"><a href="'.BASE_PATH_HREF.$result["next"]["link"].'">'.$result["next"]["text"].' &rarr;</a></li>';
	}

}
echo '</ul>';
?>
