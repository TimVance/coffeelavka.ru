/**
 * Настройки модуля, JS-сценарий
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

$(document).on('click', '.order_redirect_select', function(){
	diafan_ajax.init({
		data:{
			action: "list_site_id",
			module: 'shop',
			parent_id: 0
		},
		success: function(response) {
			if (response.error)
			{
				$(".error_shop").html(prepare(response.error)).show();
			}
			if (response.data)
			{
				$("#ipopup").html(prepare(response.data));
				centralize($("#ipopup"));
			}
		}
	});
	return false;
});
$(document).on('click', '.menu_plus', function(){
	var self = $(this);
	if (self.parents("p").attr("module_name") == 'site')
	{
		var parent_id = self.parents("p").attr("site_id");
		var action = "list_site_id";
		var site_id = 0;
		var module_name = '';
	}
	else
	{
		var parent_id = self.parents("p").attr("cat_id");
		var action = "list_module";
		var site_id = self.parents("p").attr("site_id");
		var module_name = self.parents("p").attr("module_name");
	}
	diafan_ajax.init({
		data:{
			action: action,
			module: 'menu',
			parent_id: parent_id,
			module_name: module_name,
			site_id: site_id
		},
		success: function(response) {
			if (response.data)
			{
				self.parents("p").after(prepare(response.data));
				self.removeClass("menu_plus").addClass("menu_minus");
				self.text("—");
				$(".pp_content").height($(".pp_content .menu_list_first").height() + 50);
			}
		}
	});
	return false;
});
$(document).on('click', '.menu_minus', function(){
	$(this).parents("p").next(".menu_list").remove();
	$(this).addClass("menu_plus").removeClass("menu_minus");
	$(this).text("+");
	$(".pp_content").height($(".pp_content .menu_list_first").height() + 50);
	return false;
});
$(document).on('click', '.menu_select', function(){
	$("input[name=order_redirect]").val($(this).parents("p").attr("site_id"));
	if(!$("input[name=name]").val())
	{
		$("input[name=name]").val($(this).text());
	}
	$(".menu_base_link").text($(this).text());
	$(".menu_base_link").attr("href", $(this).attr("href"));
	$('.ipopup__close').click();
	return false;
});