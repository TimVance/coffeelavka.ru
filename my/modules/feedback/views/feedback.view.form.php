<?php
/**
 * Шаблон формы добавления сообщения в обратной связи
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

if (! empty($result["text"]))
{
	echo $result["text"];
	return;
}

echo '
<div class="feedback_form">
<form method="POST" enctype="multipart/form-data" action="" class="ajax">
<input type="hidden" name="module" value="feedback">
<input type="hidden" name="action" value="add">
<input type="hidden" name="form_tag" value="'.$result["form_tag"].'">
<input type="hidden" name="site_id" value="'.$result["site_id"].'">
<input type="hidden" name="tmpcode" value="'.md5(mt_rand(0, 9999)).'">';


//заголовок блока
// if (! empty($result["name"]))
// {
// 	echo '<h3>'.$result["name"].'</h3>';
// }

$required = false;
if (! empty($result["rows"]))
{
	foreach ($result["rows"] as $row) //вывод полей из конструктора форм
	{
		if($row["required"])
		{
			$required = true;
		}
		echo '<div class="form-group feedback_form_param'.$row["id"].'">';

		switch ($row["type"])
		{
			case 'title':
				echo '<div class="infoform h4">'.$row["name"].':</div>';
				break;

			case 'text':
				echo '<label>'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<input type="text" class="form-control" name="p'.$row["id"].'" value="">';
				break;

			case "email":
				echo '<label class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<input type="email" class="form-control" name="p'.$row["id"].'" value="">';
				break;

			case "phone":
				echo '<label class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<input type="tel" class="form-control" name="p'.$row["id"].'" value="">';
				break;

			case 'textarea':
				echo '<label class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<textarea class="form-control" name="p'.$row["id"].'" cols="66" rows="10"></textarea>';
				break;

			case 'date':
			case 'datetime':
				$timecalendar  = true;
				echo '<label class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
					<input type="text" name="p'.$row["id"].'" value="" class="timecalendar form-control" showTime="'
					.($row["type"] == 'datetime'? 'true' : 'false').'">';
				break;

			case 'numtext':
				echo '<label class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<input type="number" class="form-control" name="p'.$row["id"].'" value="">';
				break;

			case 'checkbox':
				echo '<input name="p'.$row["id"].'" id="feedback_p'.$row["id"].'" value="1" type="checkbox" ><label for="feedback_p'.$row["id"].'">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').'</label>';
				break;

			case 'select':
				echo '<label class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>
				<select name="p'.$row["id"].'" class="inpselect form-control">
					<option value="" >-</option>';
				foreach ($row["select_array"] as $select)
				{
					echo '<option value="'.$select["id"].'">'.$select["name"].'</option>';
				}
				echo '</select>';
				break;

			case 'multiple':
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>';
				foreach ($row["select_array"] as $select)
				{
					echo '<input name="p'.$row["id"].'[]" id="feedback_p'.$select["id"].'[]" value="'.$select["id"].'" type="checkbox"><label for="feedback_p'.$select["id"].'[]">'.$select["name"].'</label><br>';
				}
				break;

			case "attachments":
				echo '<label class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label>';
				echo '<div class="inpattachment"><input type="file" name="attachments'.$row["id"].'[]" class="inpfiles" max="'.$row["max_count_attachments"].'"></div>';
				echo '<div class="inpattachment" style="display:none"><input type="file" name="hide_attachments'.$row["id"].'[]" class="inpfiles" max="'.$row["max_count_attachments"].'"></div>';
				if ($row["attachment_extensions"])
				{
					echo '<div class="attachment_extensions">('.$this->diafan->_('Доступные типы файлов').': '.$row["attachment_extensions"].')</div>';
				}
				break;

			case "images":
				echo '<label class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</label><div class="images"></div>';
				echo '<input type="file" name="images'.$row["id"].'" param_id="'.$row["id"].'" class="inpimages">';
				break;
		}

		if($row["text"])
		{
			echo '<div class="feedback_form_param_text">'.$row["text"].'</div>';
		}

		echo '</div>';

		if($row["type"] != 'title')
		{
			echo '<div class=" errors error_p'.$row["id"].'"'.($result["error_p".$row["id"]] ? '>'.$result["error_p".$row["id"]] : ' style="display:none">').'</div>';
		}
	}
}

//Защитный код
echo $result["captcha"];

//Кнопка Отправить
echo '<input type="submit" value="'.$this->diafan->_('Отправить', false).'" class="btn btn-warning btn-sm">';

if($required)
{
	echo '<div class="required_field"><span style="color:red;">*</span> — '.$this->diafan->_('Поля, обязательные для заполнения').'</div>';
}

echo '</form>';
echo '<div class="errors error"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>
</div>';