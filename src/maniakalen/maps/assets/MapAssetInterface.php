<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 29/01/2019
 * Time: 14:23
 */

namespace maniakalen\maps\assets;


interface MapAssetInterface {
	public static function registerMapAsset($view, $mapId, $key, $coords, $zoom);
}