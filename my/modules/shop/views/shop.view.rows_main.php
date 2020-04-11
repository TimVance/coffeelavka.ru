<?php
/**
 * Шаблон списка товаров
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

if(empty($result['rows'])) return false;

        echo '<div class="flexStart shop-list">';

		foreach ($result['rows'] as $row)
		{

			echo '<div class="js_shop text-center thumbnail" >';

			//вывод названия и ссылки на товар
			echo '<div class="shops-title"><a href="'.BASE_PATH_HREF.$row["link"].'" class="shop-item-title">'.$row["name"].'</a></div>';

			//вывод изображений товара
			if (!empty($row["img"]))
			{
				echo '<div class="shop_img shop-photo">';
				foreach ($row["img"] as $img)
				{
					switch ($img["type"])
					{
						case 'animation':
							echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'shop]">';
							break;
						case 'large_image':
							echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
							break;
						default:
							echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
							break;
					}
					echo '<img src="'.$img["src"].'" alt="'.$img["alt"].'" title="'.$img["title"].'" image_id="'.$img["id"].'" class="js_shop_img">';
					echo '<span class="shop-photo-labels">';
							echo '<span class="label label-dynamic dynamic">';
							echo $this->htmleditor('<insert name="show_dynamic" module="site" id="3" module_name="shop" element_id="'.$row['id'].'" element_type="element">');
							echo '</span>';
							if (!empty($row['hit']))
							{
								echo '<span class="label label-info hits">ХИТ</span>';
							}
							if (!empty($row['action']))
							{
								echo '<span class="label label-warning actions">АКЦИЯ</span>';
							}
							if (!empty($row['new']))
							{
								echo '<span class="label label-danger newanka">НОВИНКА</span>';
							}

						echo '</span>';
					echo '</a> ';
                    if(!empty($result['search'])) break;
				}

                // if(empty($result['search'])) {
                //     echo '<span class="js_shop_wishlist shop_wishlist shop-like'.(! empty($row["wish"]) ? ' active' : '').'">&nbsp;</span>';
                // }

				echo '</div>';
			}


			//рейтинг товара
			if (!empty($row["rating"]))
			{
				echo ' '.$row["rating"];
			}


			//вывод скидки на товар
			if (!empty($row["discount"]))
			{
				echo '<div class="shop_discount">'.$this->diafan->_('Скидка').': <span class="shop_discount_value">'.$row["discount"].' '.$row["discount_currency"].($row["discount_finish"] ? ' ('.$this->diafan->_('до').' '.$row["discount_finish"].')' : '').'</span></div>';
			}

			//теги товара
			if (!empty($row["tags"]))
			{
				echo $row["tags"];
			}

            //if(empty($result['search'])) {
				echo $this->get('buy_form', 'shop', array("row" => $row, "result" => $result));
            //}

            echo '</div>';

		}

		echo '</div>';
