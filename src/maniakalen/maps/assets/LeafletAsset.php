<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 29/01/2019
 * Time: 14:00
 */

namespace maniakalen\maps\assets;


use yii\web\AssetBundle;

class LeafletAsset extends AssetBundle implements MapAssetInterface
{

	public $key = 'pk.eyJ1IjoibWFuaWFrYWxlbiIsImEiOiJjanI2ZjJnNWwwOHA2NDluamVrN3lhdG81In0.YASdNSL-lEnFojai4C96kw';
	public $sourcePath = '@maniakalen/maps/resources';

	public $js = [
		['https://unpkg.com/leaflet@1.4.0/dist/leaflet.js', 'integrity' => 'sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==', 'crossorigin' => true],
		'js/leaflet_init.js'
	];
	public $css = [
		'css/leaflet.css'
	];

	public static function registerMapAsset( $view, $mapId, $key, $coords, $zoom, $options) {
		if (!is_array($coords) || !isset($coords[0]) || !isset($coords[1])) {
			return false;
		}
		$result = parent::register( $view );
		$opts = json_encode($options, JSON_UNESCAPED_UNICODE);
		$view->registerJs("initMap('$mapId', '$key', [{$coords[0]}, {$coords[1]}], $zoom, $opts)");
		return $result;
	}
}