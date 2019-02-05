<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 29/01/2019
 * Time: 15:28
 */

namespace maniakalen\maps\components;


use maniakalen\maps\interfaces\Negotiator;
use yii\base\Component;
use yii\di\Instance;

/**
 * Class Location
 *
 * @package maniakalen\maps\components
 *
 * Component class for facilitating geo unit and coords search
 */
class Location extends Component
{
    /**
     * LocationIQ API KEY
     *
     * @var Negotiator $negotiator
     */
	public $negotiator;

	public function init()
    {
        parent::init();

        $this->negotiator = Instance::ensure($this->negotiator, 'maniakalen\maps\interfaces\Negotiator');
    }

    /**
     * This method returns a geounit data in json format for the query string provider
     *
     * Ex. you provide Vienna, it gives you
     * {
            "place_id": "111040",
            "licence": "© LocationIQ.com CC BY 4.0, Data © OpenStreetMap contributors, ODbL 1.0",
            "osm_type": "node",
            "osm_id": "17328659",
            "boundingbox": [
            "48.0483537",
            "48.3683537",
            "16.2125042",
            "16.5325042"
            ],
            "lat": "48.2083537",
            "lon": "16.3725042",
            "display_name": "Vienna, 1010, Austria",
            "class": "place",
            "type": "city",
            "importance": 0.90144681705381,
            "icon": "https://locationiq.org/static/images/mapicons/poi_place_city.p.20.png"
        }
     *
     * But only if the importance is above 0.6 (max 1).
     *
     * @param string $unit
     *
     * @return string
     */
	public function searchGeoUnit($unit, array $params = [])
	{
        $url = sprintf($this->negotiator->getSearchByNameUrl(), urlencode($unit));
        if ($this->negotiator->supportsSearchParams() && !empty($params)) {
            foreach ($params as $key => $value) {
                $url .= sprintf("&{$key}=%s", urlencode($value));
            }
        }

		return $this->curl($url);
	}

    /**
     * From the data returned from "searchGeoUnit" method this one extracts only the coords and returns them as array of
     * [ LAT, LON ]
     *
     * @param string $unit
     *
     * @return array
     */
	public function getGeoUnitCoords($unit)
	{
		return $this->negotiator->getGeoUnitCoords($unit);
	}

    /**
     * Giving some coordinates this method returns a json in the format of
     *
     * {
            "place_id": "333758478609",
            "osm_type": "node",
            "osm_id": "5889477214",
            "licence": "© LocationIQ.com CC BY 4.0, Data © OpenStreetMap contributors, ODbL 1.0",
            "lat": "40.748736",
            "lon": "-73.98486",
            "display_name": "358, 5th Avenue, Midtown West, New York, New York County, New York, United States",
            "boundingbox": [
                "40.748736",
                "40.748736",
                "-73.98486",
                "-73.98486"
            ],
            "importance": 0.225,
            "address": {
                "house_number": "358",
                "road": "5th Avenue",
                "neighbourhood": "Midtown West",
                "city": "New York",
                "county": "New York County",
                "state": "New York",
                "country": "United States",
                "country_code": "us",
                "postcode": "10001"
            }
        }
     *
     * @param double $lat
     * @param double $lon
     *
     * @return mixed
     */
	public function searchCoords($lat, $lon, array $params = [])
    {
        $url = sprintf($this->negotiator->getSearchByCoordsUrl(), $lat, $lon);
        if ($this->negotiator->supportsSearchParams() && !empty($params)) {
            foreach ($params as $key => $value) {
                $url .= sprintf("&{$key}=%s", urlencode($value));
            }
        }
        return $this->curl($url);
    }

    /**
     * This method implements the curl call to LocationIQ api
     *
     * @access private
     *
     * @param $url
     *
     * @return mixed
     */
    private function curl($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}