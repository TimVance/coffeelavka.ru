<?php
/**
 * Шаблон формы активации купона
 *
 * Шаблонный тег <insert name="show_add_coupon" module="shop" [template="шаблон"]>:
 * форма активации купона
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

 echo '<div class="shop_block_coupon">';
 if($result["coupon"])
 {
     echo '<div style="color:green">'.$this->diafan->_('Вы активировали промокод.').'</div>';
 }
 else
 {
     echo '<form method="post" action="" class="js_shop_form shop_form ajax">
     <input type="hidden" name="action" value="add_coupon">
     <input type="hidden" name="form_tag" value="'.$result["form_tag"].'">
     <input type="hidden" name="module" value="shop"> <div>
    <div class="input-group">
     <input type="text" value="" class="form-control" name="coupon" placeholder="Ввести промокод">
     <span class="input-group-btn">
     <input type="submit" class="btn btn-danger btn-danger_mod " value="Активировать">
     </span></div></div>
     <div style="color: red" class="errors error"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>
     </form>';
 }
 echo '</div><br>';