<?php
/**
 * Created by PhpStorm.
 * User: leoflapper
 * Date: 04/05/2018
 * Time: 09:44
 */

namespace Wefabric\Countries;

use Illuminate\Support\Collection;
use Wefabric\Countries\Countries\CountryInterface;

class CountryCollection extends Collection
{

    /**
     * CountryCollection constructor.
     * @param array $items
     */
    public function __construct($items = [])
    {
        foreach($items as $iso3166 => $countryInterface) {
            $this->put($iso3166, $countryInterface);
        }
    }

    /**
     * @return array
     */
    public function getIsoCodes()
    {
        $isoCodes = [];
        foreach ($this as $country) {
            $isoCodes[] = $country->getIso();
        }
        return $isoCodes;
    }
}
