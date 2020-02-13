<?php
/**
 * Шаблон блока баннеров
 *
 * Шаблонный тег <insert name="show_block" module="bs" [count="all|количество"]
 * [cat_id="категория"] [id="номер_баннера"] [template="шаблон"]>:
 * блок баннеров
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

if (empty($result))
{
	return false;
}

if(! isset($GLOBALS['include_bs_js']))
{
	$GLOBALS['include_bs_js'] = true;
	//скрытая форма для отправки статистики по кликам
	echo '<form method="POST" enctype="multipart/form-data" action="" class="ajax js_bs_form bs_form">
	<input type="hidden" name="module" value="bs">
	<input type="hidden" name="action" value="click">
	<input type="hidden" name="banner_id" value="0">
	</form>';
}

echo '<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">';
echo '<!-- Indicators -->
<!--ol class="carousel-indicators">
	<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
	<li data-target="#carousel-example-generic" data-slide-to="1"></li>
	<li data-target="#carousel-example-generic" data-slide-to="2"></li>
</ol-->
<div class="carousel-inner" role="listbox">';
foreach ($result as $i => $row)
{
	if (! empty($row['html']) || ! empty($row['image']) || ! empty($row['swf']))
	{



				//вывод баннера в виде html разметки
				// if (! empty($row['html']))
				// {
				// 	echo $row['html'];
				// }

				//вывод баннера в виде изображения
				if (! empty($row['image']))
				{
					echo '<div class="item '.(! $i ? ' active' : '').'"><a href="' . $row['link'] . '"><img src="'.BASE_PATH.USERFILES.'/bs/'.$row['image'].'" alt="'.(! empty($row['alt']) ? $row['alt'] : '').'" title="'.(! empty($row['title']) ? $row['title'] : '').'"></a>';
				}



				//вывод описания к баннеру
				if (! empty($row['text']))
				{
					echo '<div class="carousel-caption">'.$row['text'].'</div>';
				}

				//вывод ссылки на баннер, если задана
				if (! empty($row['link']))
				{
					//echo '<a href="'.$row['link'].'" class="js_bs_counter bs_counter button" rel="'.$row['id'].'" '.(! empty($row['target_blank']) ? 'target="_blank"' : '').'>'.$this->diafan->_("Заказать").'</a>';
				}

				echo '</div>';

	}
}
echo '</div>
<!-- Controls -->
<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	<span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	<span class="sr-only">Next</span>
</a>
</div>';




