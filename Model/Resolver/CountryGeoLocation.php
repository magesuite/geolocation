<?php

namespace MageSuite\Geolocation\Model\Resolver;

class CountryGeoLocation implements \Magento\Framework\GraphQl\Query\ResolverInterface
{
    /**
     * @var \MageSuite\Geolocation\Service\CountryResolverInterface
     */
    protected $countryResolver;

    public function __construct(\MageSuite\Geolocation\Service\CountryResolverInterface $countryResolver)
    {
        $this->countryResolver = $countryResolver;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        \Magento\Framework\GraphQl\Config\Element\Field $field,
        $context,
        \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        return ['countryIso' => $this->countryResolver->resolve()];
    }
}