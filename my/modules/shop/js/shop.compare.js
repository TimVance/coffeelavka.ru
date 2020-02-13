/**
 * JS-сценарий сравнения товаров
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

$('.js_shop_compare_all, .compare_all').click(function(){
	$('.js_shop_param, .js_shop_param_existed, .shop_param, .shop_param_existed').show();
	return false;
});

$('.js_shop_compare_difference, .compare_difference').click(function(){
	$('.js_shop_param, .js_shop_param_existed, .shop_param, .shop_param_existed').hide();
	$('.js_shop_param_difference, .shop_param_difference').show();
	return false;
});

compare_height();

$(".default .jCarouselLite").jCarouselLite({
	btnNext: ".default .next",
	btnPrev: ".default .prev",
	circular:false
});

$(document).ajaxComplete(function(request, settings){
	setTimeout('compare_height()', 100);
});

$(".js_shop_depend_param, .shop_form .depend_param").change(function() {
	setTimeout('compare_height()', 100);
});

function compare_height()
{
	$('.js_shop_basic, .js_shop_compare_description, .js_shop_compare_param, .js_shop_existed_params, .js_shop, .shop_basic, .shop_compare_description, .shop_compare_param, .shop_existed_params, .shop').height('');
	var max_height_shop_basic = 0;
	var max_height_shop_compare_param = 0;
	var height = [];
	$('.js_shop_compare_param, .js_shop_existed_params, .shop_compare_param, .shop_existed_params').each(function(){
		var i = 0;
		$(this).find('.js_shop_param_existed .shop_param_existed').each(function(){
			var h = $(this).height();
			if(! height[i])
			{
				height.push(h);
			}
			else
			{
				if(height[i] < h)
				{
					height[i] = h;
				}
			}
			i = i+1;
		});
	});
	i = 0;
	$('.js_shop_compare_param, .js_shop_existed_params, .shop_compare_param, .shop_existed_params').each(function(){
		i = 0;
		$(this).find('.js_shop_param_existed, .shop_param_existed').each(function(){
			$(this).height(height[i]);
			i = i+1;
		});
	});
	$('.js_shop_basic, .js_shop_compare_description, .shop_basic, .shop_compare_description').each(function(){
		if($(this).height() > max_height_shop_basic)
		{
			max_height_shop_basic = $(this).height();
		}
	});
	$('.js_shop_basic, .js_shop_compare_description, .shop_basic, .shop_compare_description').height(max_height_shop_basic);
	$('.js_shop_compare_param, .shop_compare_param').each(function(){
		if($(this).height() > max_height_shop_compare_param)
		{
			max_height_shop_compare_param = $(this).height();
		}
	});
	$('.js_shop_compare_param, .shop_compare_param').height(max_height_shop_compare_param);
}