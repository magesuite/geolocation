<?php

namespace MageSuite\Geolocation\Service;

interface CountryResolverInterface
{
    /**
     * Returns 2 letter ISO code of a country or empty string if country was not detected
     * @param null $ip
     * @return string
     */
    public function resolve($ip = null) : string;
}
