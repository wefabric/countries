<?php

namespace Wefabric\Countries\Countries;


interface CountryInterface
{
    /**
     * @return string
     */
    public function getIso(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return float
     */
    public function getTaxRate(): int;

    /**
     * @param float $taxRate
     */
    public function setTaxRate(float $taxRate): void;
}
