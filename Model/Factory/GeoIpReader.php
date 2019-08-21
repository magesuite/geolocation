<?php

namespace MageSuite\Geolocation\Model\Factory;

class GeoIpReader
{
    /**
     * @var \MageSuite\Geolocation\Model\Asset\DatabasePathResolverInterface
     */
    protected $databasePathResolver;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(
        \MageSuite\Geolocation\Model\Asset\DatabasePathResolverInterface $databasePathResolver,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->databasePathResolver = $databasePathResolver;
        $this->logger = $logger;
    }

    /**
     * @return \GeoIp2\Database\Reader
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function create() {
        $geoIpDatabasePath = $this->databasePathResolver->getPath();

        if(empty($geoIpDatabasePath)) {
            $this->logger->error('Path to MaxMind GeoIp database was not defined.');

            throw new \InvalidArgumentException("Path to MaxMind GeoIp database was not defined.");
        }

        return new \GeoIp2\Database\Reader($geoIpDatabasePath);
    }
}