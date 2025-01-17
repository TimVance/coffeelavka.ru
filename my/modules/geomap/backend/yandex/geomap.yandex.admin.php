<?php
/**
 * Настройки карты «Яндекс.Карты» для административного интерфейса
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

class Geomap_yandex_admin
{
	public $config;
	private $diafan;

	public function __construct(&$diafan)
	{
		$this->diafan = &$diafan;
		$this->config = array(
			"name" => 'Яндекс.Карты',
			"params" => array(
				'yandex_center' => array(
					'name' => 'Центр карты',
					'type' => 'function',
				),
				'yandex_zoom' => array(
					'name' => 'Масштаб',
					'help' => 'Оптимально 13-15.',
				),
			)
		);
	}
	
	/**
	 * Редактирвание поля "Центр карты"
	 *
	 * @return void
	 */
	public function edit_variable_yandex_center($value)
	{
		echo '<div class="unit tr_geomap" backend="yandex" style="display:none">
			<div class="infofield">'.$this->diafan->_('Центр карты').'</div>';

			echo '<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>';
			
			echo '<div id="geomap_yandex_map" style="width: 100%; height: 400px;"></div>
			<input type="hidden" name="yandex_yandex_center" value="'.$value.'" id="geomap_yandex_point">';
			
			echo '<script type="text/javascript">
				ymaps.ready(function(){
					var yandex_map = new ymaps.Map("geomap_yandex_map", {
					    center: ['.($value ? $value : '55.76, 37.64').'], 
					    zoom: '.(! empty($result["config"]["yandex_zoom"]) ? $result["config"]["yandex_zoom"] : 13).'
					});
					var yandex_marker = new ymaps.GeoObject({
						// Описание геометрии.
						geometry: {
						    type: "Point",
						    coordinates: ['.($value ? $value : '55.76, 37.64').']
						},
					}, {
						draggable: true
					});
					yandex_marker.events.add("dragend", function (e) {
						var coords = e.get("target").geometry.getCoordinates();
						document.getElementById("geomap_yandex_point").value = coords.join(", ");
					});
					yandex_map.geoObjects.add(yandex_marker);
				});
			</script>';
			echo '
		</div>';
	}
}