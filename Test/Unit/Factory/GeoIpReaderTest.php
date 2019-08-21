<?php

namespace MageSuite\Geolocation\Test\Unit\Factory;

class GeoIpReaderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \MageSuite\Geolocation\Model\Factory\GeoIpReader
     */
    protected $geoIpReaderFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\MageSuite\Geolocation\Model\Asset\DatabasePathResolverInterface
     */
    protected $databasePathResolver;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->databasePathResolver = $this->getMockBuilder(\MageSuite\Geolocation\Model\Asset\DatabasePathResolverInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->geoIpReaderFactory = $this->objectManager->create(\MageSuite\Geolocation\Model\Factory\GeoIpReader::class, [
            'databasePathResolver' => $this->databasePathResolver
        ]);
    }

    public function testItThrowsExceptionWhenDatabasePathWasNotDefined() {
        $this->databasePathResolver->method('getPath')->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);

        $this->geoIpReaderFactory->create();
    }

    public function testItTriesToCreateReaderObjectWhenPathWasPassed() {
        $this->databasePathResolver->method('getPath')->willReturn('./database.mmdb');

        // following exception asserts that logic for database reader creation was executed but database itself does not exist
        $this->expectExceptionMessage('The file "./database.mmdb" does not exist or is not readable');

        $this->geoIpReaderFactory->create();
    }
}
