<?php

namespace MageSuite\Geolocation\Service;

class CountryResolver implements CountryResolverInterface
{
    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */
    protected $remoteAddress;

    /**
     * @var \MageSuite\Geolocation\Model\Factory\GeoIpReader
     */
    protected $geoIpReaderFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(
        \MageSuite\Geolocation\Model\Factory\GeoIpReader $geoIpReaderFactory,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->remoteAddress = $remoteAddress;
        $this->geoIpReaderFactory = $geoIpReaderFactory;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function resolve($ip = null): string
    {
        $ip = $ip ?? $this->remoteAddress->getRemoteAddress();

        try {
            $geoIpReader = $this->geoIpReaderFactory->create();
            $record = $geoIpReader->country($ip);

            return (string)$record->country->isoCode;
        }
        catch(\Exception $e) {
            $this->logger->error($e->getMessage());

            return '';
        }
    }
}
