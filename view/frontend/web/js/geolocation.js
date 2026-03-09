define(['jquery', 'mage/url'], function($, urlBuilder) {
    'use strict';

    return {
        /**
         * Returns two letter ISO code of users country or empty string when IP address location was not detected
         * @returns {*}
         */
        getCountryIso: function() {
            var countryIsoEndpoint = urlBuilder.build('rest/V1/geolocation/country/iso');
            var storageKey = 'mgs-geo-location';
            var cachedCountryIso = sessionStorage.getItem(storageKey);
            if (cachedCountryIso) {
                return $.Deferred().resolve(cachedCountryIso);
            }

            return $.get({
                url: countryIsoEndpoint,
                dataType: 'json'
            }).then(function(result) {
                var countryIso = result;

                sessionStorage.setItem(storageKey, countryIso);

                return countryIso;
            });
        },
    };
});
