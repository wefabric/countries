<?php
/**
 * Created by PhpStorm.
 * User: leoflapper
 * Date: 04/05/2018
 * Time: 10:12
 */

namespace Wefabric\Countries;


use Wefabric\Countries\Countries\Country;
use Mockery\Exception\InvalidArgumentException;

class CountryManager
{

    protected $collection;

    public function __construct(array $countries)
    {
        $this->fromArray($countries);
    }

    public function addCountry(Country $country)
    {
        $this->collection()->put($country->getIso(), $country);
    }

    public function default()
    {
        return $this->collection()->where('iso', config('countries.default'))->first();
    }

    public function collection()
    {
        if(!$this->collection) {
            $this->collection = new CountryCollection();
        }

        return $this->collection;
    }

    public function get(string $key)
    {
        return $this->collection()->get($key);
    }

    public function fromArray($countries)
    {
        foreach ($countries as $iso => $settings) {
            if(!isset($settings['iso'])) {
                throw new InvalidArgumentException('Country ISO not set.');
            }

            $taxRate = 0;
            if(isset($settings['tax_rate'])) {
                $taxRate = $settings['tax_rate'];
            }


            $country = new Country($settings['iso'], $taxRate);

            $this->addCountry($country);
        }
    }
}
