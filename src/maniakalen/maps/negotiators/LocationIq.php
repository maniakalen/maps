<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 2/4/2019
 * Time: 10:01 AM
 */

namespace maniakalen\maps\negotiators;


use maniakalen\maps\interfaces\Negotiator;

class LocationIq implements Negotiator
{
    public $key;
    public $format = 'json';
    public function getSearchByNameUrl()
    {
        return 'https://eu1.locationiq.com/v1/search.php?key='
               . $this->key . '&q=%s&format=' . $this->format;
    }

    public function getSearchByCoordsUrl()
    {
        return "https://eu1.locationiq.com/v1/reverse.php?key={$this->key}&lat=%s&lon=%s&format={$this->format}";
    }

    public function getGeoUnitCoords($data)
    {
        $data = json_decode($data);
        $best = array_filter($data, function($item) { return $item->importance > 0.6; });
        $best = reset($best);
        return $best?[$best->lat, $best->lon]:[];
    }
}