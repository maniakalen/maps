<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 29/01/2019
 * Time: 15:28
 */

namespace maniakalen\maps\components;


use yii\base\Component;

class Location extends Component
{
	public $key;
	public function searchGeoUnit($unit)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://eu1.locationiq.com/v1/search.php?key=' . $this->key . '&q=' . urlencode($unit) . '&format=json'
		));
		$result = curl_exec($curl);
		curl_close($curl);

		return $result;
	}

	public function getGeoUnitCoords($unit)
	{
		$data = $this->searchGeoUnit($unit);
		$data = json_decode($data);
		$best = array_filter($data, function($item) { return $item->importance > 0.6; });
		$best = reset($best);
		return $best?[$best->lat, $best->lon]:[];
	}
}