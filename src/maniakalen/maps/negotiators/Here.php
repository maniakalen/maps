<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 2/4/2019
 * Time: 10:10 AM
 */

namespace maniakalen\maps\negotiators;


use maniakalen\maps\interfaces\Negotiator;

class Here implements Negotiator
{
    public $appId;
    public $appCode;
    public $supportsParams;
    public $format = 'json';
    public function getSearchByNameUrl()
    {
        return 'https://geocoder.api.here.com/6.2/geocode.' . $this->format . '?app_id='
               . $this->appId . '&app_code=' . $this->appCode . '&searchtext=%s';
    }

    public function getSearchByCoordsUrl()
    {
        return 'https://reverse.geocoder.api.here.com/6.2/reversegeocode.' . $this->format . '?app_id='
               . $this->appId . '&app_code=' . $this->appCode . '&mode=retrieveAddresses&prox=%s,%s,250';
    }

    public function getGeoUnitCoords($data)
    {
        if (is_string($data)) {
            $data = json_decode($data, JSON_UNESCAPED_UNICODE);
        }
        if (isset($data['Response'])) {
            $data = $data['Response']['View']['Result'];
        }

        $item = reset($data);
        if (isset($item['Location'])) {
            return array_values($item['Location']['DisplayPosition']);
        }

        return [];
    }

    public function supportsSearchParams()
    {
        return $this->supportsParams;
    }
}