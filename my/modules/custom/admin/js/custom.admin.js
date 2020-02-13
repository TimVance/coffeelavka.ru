/**
 * Темы, JS-сценарий
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

var fast_edit_current = {
	old_value: false,
	element: false,
	init: function(){
		$(document).on('change', this.element, function () {
 			fast_edit_current.change($(this));
		});
	},
	change: function(e){
		var install_sql = false;
		if (e.is(':checked') && e.attr('install_sql')) {
			if (confirm(e.attr('install_sql'))) {
				install_sql = true;
			}
		}
		diafan_ajax.init({
			data:{
				action:'fast_save',
				name:e.attr('name'),
				value:(e.is(':checked') ? '1' : '0'),
				type:e.attr('type'),
				id:e.attr('row_id'),
				install_sql: install_sql,
			},
			success: function(response){
				if (response.res == false) {
					e.val(fast_edit_current.old_value);
				}
			}
		});
	}
}

fast_edit_current.element = ".fast_edit_current input";
fast_edit_current.init();