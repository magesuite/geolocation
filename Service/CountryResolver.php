<?php

declare(strict_types=1);

namespace MageSuite\Geolocation\Service;

class CountryResolver implements CountryResolverInterface
{
    public function __construct(
        protected \MageSuite\Geolocation\Model\Factory\GeoIpReader $geoIpReaderFactory,
        protected \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        protected \Psr\Log\LoggerInterface $logger
    ) {}

    /**
     * @inheritDoc
     */
    public function resolve(?string $ip = null): string
    {
        $ip ??= $this->remoteAddress->getRemoteAddress();

        try {
            $geoIpReader = $this->geoIpReaderFactory->create();
            $record = $geoIpReader->country((string)$ip);

            return (string)$record->country->isoCode;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return '';
        }
    }
}
