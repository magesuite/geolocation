define(['jquery', 'mage/url'], function($, urlBuilder) {
    'use strict';

    return {
        /**
         * Returns two letter ISO code of users country or empty string when IP address location was not detected
         * @returns {*}
         */
        getCountryIso: function() {
            var graphqlUrl = urlBuilder.build('/graphql');
            var storageKey = 'mgs-geo-location';
            var cachedCountryIso = sessionStorage.getItem(storageKey);
            if (cachedCountryIso) {
                return $.Deferred().resolve(cachedCountryIso);
            }

            return $.post({
                url: graphqlUrl,
                contentType: 'application/json',
                data: JSON.stringify({
                    query: `
                            {
                                countryGeoLocation {
                                    countryIso
                                }
                            }
                        `,
                }),
            }).then(function(result) {
                var countryIso = result.data.countryGeoLocation.countryIso;

                sessionStorage.setItem(storageKey, cachedCountryIso);

                return countryIso;
            });
        },
    };
});
