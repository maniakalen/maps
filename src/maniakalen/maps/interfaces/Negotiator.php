<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 2/4/2019
 * Time: 9:59 AM
 */

namespace maniakalen\maps\interfaces;


interface Negotiator
{
    public function getSearchByNameUrl();
    public function getSearchByCoordsUrl();
    public function getGeoUnitCoords($data);
}