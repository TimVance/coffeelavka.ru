<?php
/**
 * Шаблон блока товаров, которые обычно покупают с текущим товаром
 *
 * Шаблонный тег <insert name="show_block" module="shop" [count="количество"]
 * [images="количество_изображений"] [images_variation="тег_размера_изображений"]
 * [template="шаблон"]>:
 * блок товаров, которые обычно покупают с текущим товаром
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

if (!empty($result["rows"]))
{
	echo '<div class="shop-buyers-buy  row text-center" >';
	echo '<h3 class="text-left" style="padding-left:15px;">'.$this->diafan->_('C этим товаром покупают').':</h3>';
		echo '<div class="shop_order_rel_list">';
			foreach ($result["rows"] as $row)
			{
				echo '<div class="js_shop shop-item-small shop col-md-3"><div class="thumbnail">';
				//вывод названия и ссылки на товар
				echo '<div class="h3"><a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a></div>';

					echo '<a href="'.BASE_PATH_HREF.$row["link"].'">';

					//изображения товара
					if (!empty($row["img"]))
					{
						$img = $row["img"][0];
						// echo '<span class="shop-item-small-image" style="background-image:url('.$img["src"].')">&nbsp;</span>';
						echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">';
					}
					echo '</a>';


					//кнопка "Купить"
			        echo $this->get('buy_form_order_rel', 'shop', array("row" => $row, "result" => $result));

		        echo '</div></div>';

			}
		echo '</div>';
	echo '</div>';
}