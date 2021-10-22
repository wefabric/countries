<?php
/**
 * Created by PhpStorm.
 * User: leoflapper
 * Date: 04/05/2018
 * Time: 09:44
 */

namespace Wefabric\Countries;

use Illuminate\Support\Collection;
use Wefabric\Countries\Countries\Country;
use Wefabric\Countries\Countries\CountryInterface;

class CountryCollection extends Collection
{

    /**
     * CountryCollection constructor.
     * @param array $items
     */
    public function __construct($items = [])
    {
        foreach($items as $iso => $countryInterface) {
            $this->put($iso, $countryInterface);
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

    /**
     * @return CountryCollection
     */
    public function getAsOptions(): CountryCollection
    {
        return $this->mapWithKeys(function (Country $country) {
            return [$country->getIso() => $country->getName()];
        });
    }
}
