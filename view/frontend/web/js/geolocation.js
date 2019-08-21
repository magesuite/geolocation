define(['jquery', 'mage/url'], function ($, urlBuilder) {
    "use strict";

    return {
        /**
         * Returns two letter ISO code of users country or empty string when IP address location was not detected
         * @returns {*}
         */
        getCountryIso: function () {
            var graphqlUrl = urlBuilder.build('/graphql');
            var cachedCountryIso = $.cookie('geo-location-country-iso');

            if(cachedCountryIso !== undefined && cachedCountryIso !== null) {
                return $.Deferred().resolve(cachedCountryIso);
            }

            return $.post({
                url: graphqlUrl,
                contentType: "application/json",
                data: JSON.stringify({
                    query:
                        `
                            {
                                countryGeoLocation {
                                    countryIso
                                }
                            }
                        `
                }),
            }).then(function(result) {
                var countryIso = result.data.countryGeoLocation.countryIso;

                $.cookie('geo-location-country-iso', countryIso, { expires: 1 });

                return countryIso;
            });
        }
    };
});