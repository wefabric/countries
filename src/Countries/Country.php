<?php
/**
 * Created by PhpStorm.
 * User: leoflapper
 * Date: 04/05/2018
 * Time: 09:38
 */

namespace Wefabric\Countries\Countries;


use Wefabric\Countries\Codes;
use Wefabric\Countries\Exceptions\CountryNotFoundException;
use Illuminate\Contracts\Support\Arrayable;

class Country implements CountryInterface, Arrayable
{
    /**
     * The country ISO3166
     * @var string
     */
    public string $iso = 'EN';

    public int $taxRate = 0;

    /**
     * @var string
     */
    public string $name = 'test';

    /**
     * Country constructor.
     * @param $iso
     * @param $taxRate
     * @throws CountryNotFoundException
     */
    public function __construct($iso, $taxRate)
    {
        $this->setIso($iso);
        $this->setTaxRate($taxRate);
        $this->setName();
    }

    /**
     * @param string $iso3166
     * @throws CountryNotFoundException
     */
    public function setIso(string $iso)
    {
        $iso = strtoupper($iso);
        if(!Codes::country($iso)) {
            throw new CountryNotFoundException(sprintf('Country with iso "%s" not found', $iso));
        }

        $this->iso = $iso;
    }

    /**
     * @return string
     */
    public function getIso(): string
    {
        return strtoupper($this->iso);
    }

    /**
     *
     */
    public function setName()
    {
        $this->name = $this->translate(Codes::country($this->iso));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Translates the given country name
     *
     * @param $key
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    private function translate($key)
    {
        return trans('countries::countries.'.$key);
    }


    public function getTaxRate(): int
    {
        return $this->taxRate;
    }

    /**
     * @param float $taxRate
     */
    public function setTaxRate(float $taxRate): void
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'iso' => $this->getIso(),
            'name' => $this->getName(),
            'tax_rate' => $this->getTaxRate()
        ];
    }

    public function __get($key)
    {
        if($key === 'iso' || $key === 'id') {
            return $this->getIso();
        }
    }
}
