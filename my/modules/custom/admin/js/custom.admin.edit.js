/**
 * Редактирование темы, JS-сценарий
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */


validate.success = function(response){
	var install_sql = 0;
	if (response.errors && response.errors.install_sql){
		var cnt = 0;
		$.each(response.errors, function (k, val) {
			cnt++;
		});
		if (cnt < 2) {
			if (confirm(prepare(response.errors.install_sql))) {
				install_sql = 1;
				response.result = 'success';
			}
			$('input[name=name]').after('<input name="install_sql" type="hidden" value="'+install_sql+'">');
		}
	}
}