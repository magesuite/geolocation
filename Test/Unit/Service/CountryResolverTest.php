<?php

namespace MageSuite\Geolocation\Test\Unit\Service;

class CountryResolverTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\GeoIp2\Database\Reader
     */
    protected $geoIpReaderStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\MageSuite\Geolocation\Model\Factory\GeoIpReader
     */
    protected $geoIpReaderFactory;

    /**
     * @var \MageSuite\Geolocation\Service\CountryResolver
     */
    protected $countryResolver;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Psr\Log\LoggerInterface
     */
    protected $loggerMock;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->geoIpReaderStub = $this->getMockBuilder(\GeoIp2\Database\Reader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->geoIpReaderFactory = $this->getMockBuilder(\MageSuite\Geolocation\Model\Factory\GeoIpReader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(\Psr\Log\LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->geoIpReaderFactory->method('create')->willReturn($this->geoIpReaderStub);

        $this->countryResolver = $this->objectManager->create(\MageSuite\Geolocation\Service\CountryResolver::class, [
            'geoIpReaderFactory' => $this->geoIpReaderFactory,
            'logger' => $this->loggerMock
        ]);
    }

    public function testItReturnsCorrectIsoCodeWhenItWasFoundInDatabase() {
        $country = new \GeoIp2\Model\Country(['country' => ['iso_code' => 'DE']]);

        $this->geoIpReaderStub->method('country')->willReturn($country);

        $this->assertEquals('DE', $this->countryResolver->resolve());
    }

    public function testItReturnsEmptyStringWhenAnyExceptionWasThrown() {
        $this->geoIpReaderStub->method('country')->willThrowException(new \Exception());

        $this->assertEquals('', $this->countryResolver->resolve());
    }

    public function testItLogsErrorsWhenAnyExceptionIsThrown() {
        $this->geoIpReaderStub->method('country')->willThrowException(new \Exception('exception message'));

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with('exception message');

        $this->countryResolver->resolve();
    }
}
