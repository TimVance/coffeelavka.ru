<?php
/**
 * Шаблон формы добавления комментария
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

echo '<div class="comments_form">
<form method="POST" action="" id="comments'.($result["parent_id"] ? $result["parent_id"].'_result' : '').'" class="ajax" enctype="multipart/form-data">
<input type="hidden" name="module" value="comments">
<input type="hidden" name="action" value="add">
<input type="hidden" name="form_tag" value="'.$result["form_tag"].'">
<input type="hidden" name="parent_id" value="'.$result["parent_id"].'">
<input type="hidden" name="element_id" value="'.$result["element_id"].'">
<input type="hidden" name="module_name" value="'.$result["module_name"].'">
<input type="hidden" name="element_type" value="'.$result["element_type"].'">
<input type="hidden" name="tmpcode" value="'.md5(mt_rand(0, 9999)).'">';

if(! $result["parent_id"])
{
	// echo '<div class="block_header">'.$this->diafan->_('Оставьте комментарий').'</div>';
}

$required = false;
if (! empty($result["params"]))
{
	foreach ($result["params"] as $row)
	{
		if($row["required"])
		{
			$required = true;
		}
		echo '<div class="comments_form_param'.$row["id"].'">';

		switch ($row["type"])
		{
			case 'title':
				echo '<div class="infoform">'.$row["name"].':</div>';
				break;

			case 'text':
				echo '<div class="form-group"><div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<input type="text" class="form-control" name="p'.$row["id"].'" value=""></div>';
				break;

			case "email":
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<input type="mail" class="form-control" name="p'.$row["id"].'" value="">';
				break;

			case "phone":
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<input type="tel" class="form-control" name="p'.$row["id"].'" value="">';
				break;

			case 'textarea':
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<textarea class="form-control" name="p'.$row["id"].'" rows="10" cols="30"></textarea>';
				break;

			case 'date':
			case 'datetime':
				$timecalendar  = true;
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
					<input type="text" name="p'.$row["id"].'" value="" class="timecalendar form-control showTime="'
					.($row["type"] == 'datetime'? 'true' : 'false').'">';
				break;

			case 'numtext':
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<input class="form-control" type="number" name="p'.$row["id"].'" size="5" value="">';
				break;

			case 'checkbox':
				echo '<input name="p'.$row["id"].'" id="comment_p'.$row["id"].'" value="1" type="checkbox"><label for="comment_p'.$row["id"].'">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').'</label>';
				break;

			case 'select':
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<select name="p'.$row["id"].'" class="inpselect form-control>
					<option value="">-</option>';
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
					echo '<input name="p'.$row["id"].'[]" id="comment_p'.$select["id"].'[]" value="'.$select["id"].'" type="checkbox"><label for="comment_p'.$select["id"].'[]">'.$select["name"].'</label><br>';
				}
				break;

			case "attachments":
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>';
				echo '<div class="inpattachment"><input type="file" name="attachments'.$row["id"].'[]" class="inpfiles" max="'.$row["max_count_attachments"].'"></div>';
				echo '<div class="inpattachment" style="display:none"><input type="file" name="hide_attachments'.$row["id"].'[]" class="inpfiles" max="'.$row["max_count_attachments"].'"></div>';
				if ($row["attachment_extensions"])
				{
					echo '<div class="attachment_extensions">('.$this->diafan->_('Доступные типы файлов').': '.$row["attachment_extensions"].')</div>';
				}
				break;

			case "images":
				echo '<div class="infofield">'.$row["name"].($row["required"] ? '<span style="color:red;">*</span>' : '').':</div>
				<div class="images"></div>';
				echo '<input type="file" name="images'.$row["id"].'" class="inpimages" param_id="'.$row["id"].'">';
				break;
		}
		if($row["text"])
		{
			echo '<div class="comments_form_param_text">'.$row["text"].'</div>';
		}
		echo '</div>';
		echo '<div class="errors error_p'.$row["id"].'"'.($result["error_p".$row["id"]] ? '>'.$result["error_p".$row["id"]] : ' style="display:none">').'</div>';
	}
}

if($result["bbcode"])
{
	echo $this->get('get', 'bbcode', array("name" => "comment", "tag" => "comments".$result["parent_id"], "value" => ""));
}
else
{
	echo '<textarea class="form-control" rows="5" name="comment"></textarea>';
}
echo '<div class="errors error"'.($result["error"] ? '>'.$result["error"] : ' style="display:none">').'</div>';

if($result['use_mail'])
{
	echo '<div class="infoform">'.$this->diafan->_('Подписаться на комментарии (впишите e-mail)').':</div>';
	echo '<input name="mail" type="email" class="form-control" value="">';
	echo '<div class="errors error_mail"'.($result["error_mail"] ? '>'.$result["error_mail"] : ' style="display:none">').'</div>';
}
echo '<br>';

//Защитный код
echo $result["captcha"];

//Кнопка Отправить
echo '<input type="submit" value="'.$this->diafan->_('Отправить', false).'" class="btn btn-warning btn-sm">';

if($required)
{
	echo '<div class="required_field"><span style="color:red;">*</span> — '.$this->diafan->_('Поля, обязательные для заполнения').'</div>';
}

echo '</form>
</div>';