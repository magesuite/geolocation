<?php

namespace MageSuite\Geolocation\Model\Asset;

class DummyDatabasePathResolver implements DatabasePathResolverInterface
{
    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return null;
    }
}