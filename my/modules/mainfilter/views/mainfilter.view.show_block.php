<?php

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

echo '<div class="mainfilter-wrapper">';
    echo '<br>'.$this->htmleditor('<insert name="show_block" id="14" module="site">');
    echo '<form method="post" action="'.BASE_PATH_HREF.'new/" class="js_mainfilter_form ajax">';
        echo '<input type="hidden" name="module" value="mainfilter">';
        echo '<input type="hidden" name="action" value="get">';
        echo '<input type="hidden" name="cat_id" value="52">';
        echo '<div class="mainfilter-params flexStart">';
            foreach ($result["params"] as $pid => $param) {
                echo '<div class="mainfilter-param">';
                    echo '<div class="mainfilter-param-title">'.$param[0]["pname"].'</div>';
                    echo '<div class="mainfilter-elements">';
                    foreach ($param as $item) {
                        echo '<label class="mainfilter-element">
                                <input name="p'.$item["pid"].'[]" type="checkbox" value="'.$item["id"].'">
                                <span>'.$item["name"].'</span>
                               </label>';
                    }
                    echo '</div>';
                echo '</div>';
            }
            echo '<div class="buttons">
                <input class="btn-warning" type="reset" value="Сбросить фильтр">
                <input class="btn-warning" type="reset" value="Показать все">
            </div>';
        echo '</div>';
    echo '</form>';
    echo '<div class="mainfilter-catalog"></div>';

echo '</div>';