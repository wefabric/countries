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
    public string $iso3166 = 'EN';

    /**
     * @var float
     */
    public float $taxRate = 0.0;

    /**
     * @var string
     */
    public string $name = 'test';

    /**
     * Country constructor.
     * @param $iso3166
     * @param $taxRate
     * @throws CountryNotFoundException
     */
    public function __construct($iso3166, $taxRate)
    {
        $this->setIso($iso3166);
        $this->setTaxRate($taxRate);
        $this->setName();
    }

    /**
     * @param string $iso3166
     * @throws CountryNotFoundException
     */
    public function setIso(string $iso3166)
    {
        $iso3166 = strtoupper($iso3166);
        if(!Codes::country($iso3166)) {
            throw new CountryNotFoundException(sprintf('Country with iso1366 "%s" not found', $iso3166));
        }

        $this->iso3166 = $iso3166;
    }

    /**
     * @return string
     */
    public function getIso(): string
    {
        return strtoupper($this->iso3166);
    }

    /**
     *
     */
    public function setName()
    {
        $this->name = $this->translate(Codes::country($this->iso3166));
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

    /**
     * @return float
     */
    public function getTaxRate(): float
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
}
