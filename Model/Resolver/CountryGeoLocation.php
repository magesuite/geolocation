<?php

namespace MageSuite\Geolocation\Model\Resolver;

class CountryGeoLocation implements \Magento\Framework\GraphQl\Query\ResolverInterface
{
    /**
     * @var \MageSuite\Geolocation\Service\CountryResolverInterface
     */
    protected $countryResolver;

    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface
     */
    protected $cookieManager;

    public function __construct(
        \MageSuite\Geolocation\Service\CountryResolverInterface $countryResolver,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
    )
    {
        $this->countryResolver = $countryResolver;
        $this->cookieManager = $cookieManager;
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
        $countryIso = $this->cookieManager->getCookie('COUNTRY_CODE') ?
            $this->cookieManager->getCookie('COUNTRY_CODE') :
            $this->countryResolver->resolve();

        return ['countryIso' => $countryIso];
    }
}