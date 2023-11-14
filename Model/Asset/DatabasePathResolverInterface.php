<?php

namespace MageSuite\Geolocation\Model\Asset;

interface DatabasePathResolverInterface
{
    /**
     * Returns path to GeoIp mmdb database file
     * @return string
     */
    public function getPath();
}
