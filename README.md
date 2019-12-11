### Geolocation extension

Extension allows getting current country based on users IP address.

#### Frontend helper

Two letter ISO country code can be fetched by javascript in the following way:

```html
<script>
    require(["geolocation"], function(geolocation){
        geolocation.getCountryIso().then(function(countryIso) {
            console.log(countryIso);
        });
    });
</script>
```

Empty string will be returned if it was not possible to GeoLocate user based on his IP address.

#### Backend helper

If geolocation is needed inside BE logic then `\MageSuite\Geolocation\Service\CountryResolverInterface` should be injected into class constructor.

It contains `resolve` method that will return two letter ISO country code of current user. Empty string will be returned if it was not possible to GeoLocate user based on his IP address.

Custom IP address can be passed to `resolve` method, otherwise IP from server headers will be taken into account.

#### Testing

If you'd like to test integration with 3rd party code you can fake country returned by endpoint.

To do so create cookie named `COUNTRY_CODE` with ISO code of expected country as value.

Keep in mind that javascript library caches returned country code, after each change to the cookie value browsers session storage must be cleared.