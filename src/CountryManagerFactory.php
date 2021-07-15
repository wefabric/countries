<?php
/**
 * Created by SlickLabs - Wefabric.
 * User: nathanjansen <nathan@wefabric.nl>
 * Date: 26-03-18
 * Time: 13:11
 */

namespace Wefabric\Countries;

class CountryManagerFactory
{
    /**
     * @var array[]
     */
    protected $items;

    public function __construct(array $config)
    {
        $this->items = $config;
    }

    /**
     * @param array $config
     * @return SlickAPIManager
     */
    public static function create(array $config): CountryManager
    {
        return new CountryManager($config);
    }
}
