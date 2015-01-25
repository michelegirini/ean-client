<?php

/**
 * Description of the EAN Hotel API
 *
 * @see GuzzleHttp\Command\Guzzle\Description
 */
return [
    'description' => 'EAN Hotel API for selling hotel reservations',
    'operations' => [
        'AbstractOperation' => [
            'parameters' => [
                'generalEndpoint' => [
                    'location' => 'uri',
                    'required' => true,
                    'default' => 'https://api.ean.com'
                ],
                'bookingEndpoint' => [
                    'location' => 'uri',
                    'required' => true,
                    'default' => 'https://book.api.ean.com'
                ],
                'cid' => [
                    'location' => 'query',
                    'required' => true
                ],
                'apiKey' => [
                    'location' => 'query',
                    'required' => true
                ],
                'minorRev' => [
                    'location' => 'query',
                    'required' => true,
                    'default' => '28'
                ],
                'locale' => [
                    'location' => 'query',
                    'default' => 'en_US'
                ],
                'currencyCode' => [
                    'location' => 'query',
                    'default' => 'AUD'
                ],
                'customerSessionId' => [
                    'location' => 'query'
                ],
                'customerIpAddress' => [
                    'location' => 'query',
                    'required' => true
                ],
                'customerUserAgent' => [
                    'location' => 'query',
                    'required' => true
                ],
                'Accept' => [
                    'location' => 'header',
                    'static' => true,
                    'default' => 'application/xml'
                ],
                'Accept-Encoding' => [
                    'location' => 'header',
                    'default' => 'gzip,deflate'
                ]
            ],
        ],
        'GetHotelList' => [
            'extends' => 'AbstractOperation',
            'httpMethod' => 'GET',
            'uri' => '{+generalEndpoint}/ean-services/rs/hotel/v3/list',
            'summary' => 'Retrieve a list of hotels by location or a list of specific hotelIds.',
            'responseModel' => 'HotelListResponse',
            'data' => [
                'xmlRoot' => [
                    'name' => 'HotelListRequest',
                ]
            ],
            'parameters' => [
                'apiExperience' => [
                    'location' => 'xml.query',
                ],
                'arrivalDate' => [
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::formatUsDate'
                    ]
                ],
                'departureDate' => [
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::formatUsDate'
                    ]
                ],
                'numberOfResults' => [
                    'type' => 'numeric',
                    'location' => 'xml.query'
                ],
                'RoomGroup' => [
                    'type' => 'array',
                    'location' => 'xml.query',
                    'items' => [
                        'type' => 'object',
                        'sentAs' => 'Room',
                        'properties' => [
                            'numberOfAdults' => [
                                'type' => 'numeric',
                                'minimum' => 1,
                                'required' => true
                            ],
                            'numberOfChildren' => [
                                'type' => 'numeric',
                            ],
                            'childAges' => [
                                'filters' => [
                                    'Otg\Ean\Filter\StringFilter::joinValues'
                                ]
                            ]
                        ]
                    ]
                ],
                'includeDetails' => [
                    'type' => 'boolean',
                    'location' => 'xml.query'
                ],
                'includeHotelFeeBreakdown' => [
                    'type' => 'boolean',
                    'location' => 'xml.query'
                ],

                /* Primary search methods */
                /* Use only one of these methods at a time */

                /* Method 1: City/state/country search */
                'city' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'stateProvinceCode' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'countryCode' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

                /* Method 2: Use a free text destination string */
                'destinationString' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

                /* Method 3: Use a destinationId */
                'destinationId' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

                /* Method 4: Use a list of hotelIds */
                'hotelIdList' => [
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::joinValues'
                    ]
                ],

                /* Method 5: Search within a geographical area */
                'latitude' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'longitude' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'searchRadius' => [
                    'type' => 'numeric',
                    'location' => 'xml.query'
                ],
                'searchRadiusUnit' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

                /* Additional (secondary) search methods */

                'address' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'postalCode' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'propertyName' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

                /* Filtering methods */

                'includeSurrounding' => [
                    'type' => 'boolean',
                    'location' => 'xml.query'
                ],
                'propertyCategory' => [
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::joinValues'
                    ]
                ],
                // note: amenities is deprecated in favour of local filtering
                // http://dev.ean.com/docs/hotel-list/#amenities
                'amenities' => [
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::joinValues'
                    ]
                ],
                'maxStarRating' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'minStarRating' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'minRate' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'maxRate' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'numberOfBedRooms' => [
                    'type' => 'numeric',
                    'location' => 'xml.query'
                ],
                'maxRatePlanCount' => [
                    'type' => 'numeric',
                    'location' => 'xml.query'
                ],
                'minTripAdvisorRating' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'maxTripAdvisorRating' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

                /* Sorting options */

                'sort' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

                /* Additional data request */

                'options' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

                /* Paging for more hotels */

                'cacheKey' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'cacheLocation' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],

            ]
        ],
        'GetRoomAvailability' => [
            'extends' => 'AbstractOperation',
            'httpMethod' => 'GET',
            'uri' => '{+generalEndpoint}/ean-services/rs/hotel/v3/avail',
            'summary' => 'Retrieve all available rooms at a specific hotel that accommodate the provided guest count and any other criteria.',
            'responseModel' => 'RoomAvailabilityResponse',
            'data' => [
                'xmlRoot' => [
                    'name' => 'HotelRoomAvailabilityRequest',
                ],
            ],
            'parameters' => [
                'apiExperience' => [
                    'location' => 'xml.query',
                ],
                'hotelId' => [
                    'type' => 'numeric',
                    'required' => true,
                    'location' => 'xml.query'
                ],
                'arrivalDate' => [
                    'required' => true,
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::formatUsDate'
                    ]
                ],
                'departureDate' => [
                    'required' => true,
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::formatUsDate'
                    ]
                ],
                'numberOfBedrooms' => [
                    'type' => 'numeric',
                    'location' => 'xml.query'
                ],
                'supplierType' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'rateKey' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'RoomGroup' => [
                    'type' => 'array',
                    'location' => 'xml.query',
                    'items' => [
                        'type' => 'object',
                        'sentAs' => 'Room',
                        'properties' => [
                            'numberOfAdults' => [
                                'type' => 'numeric',
                                'minimum' => 1,
                                'required' => true
                            ],
                            'numberOfChildren' => [
                                'type' => 'numeric',
                            ],
                            'childAges' => [
                                'filters' => [
                                    'Otg\Ean\Filter\StringFilter::joinValues'
                                ]
                            ]
                        ]
                    ]
                ],
                'roomTypeCode' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'rateCode' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'includeDetails' => [
                    'type' => 'boolean',
                    'location' => 'xml.query'
                ],
                'includeRoomImages' => [
                    'type' => 'boolean',
                    'location' => 'xml.query'
                ],
                'includeHotelFeeBreakdown' => [
                    'type' => 'boolean',
                    'location' => 'xml.query'
                ],
                'options' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
            ]
        ],
        'PostReservation' => [
            'extends' => 'AbstractOperation',
            'httpMethod' => 'POST',
            'uri' => '{+bookingEndpoint}/ean-services/rs/hotel/v3/res',
            'summary' => 'Requests a reservation for the specified room(s]',
            'responseModel' => 'ReservationResponse',
            'data' => [
                'xmlRoot' => [
                    'name' => 'HotelRoomReservationRequest',
                ],
            ],
            'parameters' => [
                'additionalData' => [
                    'location' => 'query'
                ],
                'apiExperience' => [
                    'location' => 'xml.query',
                ],
                'hotelId' => [
                    'type' => 'numeric',
                    'required' => true,
                    'location' => 'xml.query'
                ],
                'arrivalDate' => [
                    'required' => true,
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::formatUsDate'
                    ]
                ],
                'departureDate' => [
                    'required' => true,
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::formatUsDate'
                    ]
                ],
                'supplierType' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'rateKey' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'roomTypeCode' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'rateCode' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'RoomGroup' => [
                    'type' => 'array',
                    'location' => 'xml.query',
                    'required' => true,
                    'items' => [
                        'type' => 'object',
                        'sentAs' => 'Room',
                        'properties' => [
                            'numberOfAdults' => [
                                'type' => 'numeric',
                                'minimum' => 1,
                                'required' => true
                            ],
                            'numberOfChildren' => [
                                'type' => 'numeric'
                            ],
                            'childAges' => [
                                'filters' => [
                                    'Otg\Ean\Filter\StringFilter::joinValues'
                                ]
                            ],
                            'firstName' => [
                                'type' => 'string',
                                'required' => true,
                                'filters' => [
                                    [
                                        'method' => 'substr',
                                        'args' => ['@value', '0', '25']
                                    ]
                                ]
                            ],
                            'lastName' => [
                                'type' => 'string',
                                'required' => true,
                                'filters' => [
                                    [
                                        'method' => 'substr',
                                        'args' => ['@value', '0', '40']
                                    ]
                                ]
                            ],
                            'bedTypeId' => [
                                'type' => 'numeric'
                            ],
                            'numberOfBeds' => [
                                'type' => 'numeric'
                            ],
                            'smokingPreference' => [
                                'type' => 'string'
                            ],
                        ]
                    ]
                ],
                'affiliateConfirmationId' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'affiliateCustomerId' => [
                    'type' => 'string',
                    'location' => 'xml.query'
                ],
                'itineraryId' => [
                    'type' => 'numeric',
                    'location' => 'xml.query'
                ],
                'chargeableRate' => [
                    'type' => 'numeric',
                    'location' => 'xml.query',
                    'required' => true
                ],
                'specialInformation' => [
                    'type' => 'string',
                    'location' => 'xml.query',
                    'filters' => [
                        'Otg\Ean\Filter\StringFilter::removeNewLines',
                        [
                            'method' => 'substr',
                            'args' => ['@value', '0', '256']
                        ]
                    ]
                ],
                'sendReservationEmail' => [
                    'type' => 'boolean',
                    'location' => 'xml.query'
                ],
                'ReservationInfo' => [
                    'type' => 'object',
                    'required' => true,
                    'location' => 'xml.query',
                    'properties' => [
                        'email' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'firstName' => [
                            'type' => 'string',
                            'required' => true,
                            'filters' => [
                                [
                                    'method' => 'substr',
                                    'args' => ['@value', '0', '25']
                                ]
                            ]
                        ],
                        'lastName' => [
                            'type' => 'string',
                            'required' => true,
                            'filters' => [
                                [
                                    'method' => 'substr',
                                    'args' => ['@value', '0', '40']
                                ]
                            ]
                        ],
                        'homePhone' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'workPhone' => [
                            'type' => 'string'
                        ],
                        'extension' => [
                            'type' => 'string',
                            'filters' => [
                                [
                                    'method' => 'substr',
                                    'args' => ['@value', '0', '5']
                                ]
                            ]
                        ],
                        'faxPhone' => [
                            'type' => 'string'
                        ],
                        'companyName' => [
                            'type' => 'string'
                        ],
                        'creditCardType' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'creditCardNumber' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'creditCardIdentifier' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'creditCardExpirationMonth' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'creditCardExpirationYear' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'creditCardPasHttpUserAgent' => [
                            'type' => 'string'
                        ],
                        'creditCardPasHttpAccept' => [
                            'type' => 'string'
                        ],
                        'creditCardPasPaRes' => [
                            'type' => 'string'
                        ]
                    ],
                ],
                'AddressInfo' => [
                    'type' => 'object',
                    'location' => 'xml.query',
                    'required' => true,
                    'properties' => [
                        'address1' => [
                            'type' => 'string',
                            'required' => true,
                            'filters' => [
                                [
                                    'method' => 'substr',
                                    'args' => ['@value', '0', '28']
                                ]
                            ]
                        ],
                        'address2' => [
                            'type' => 'string',
                            'filters' => [
                                [
                                    'method' => 'substr',
                                    'args' => ['@value', '0', '28']
                                ]
                            ]
                        ],
                        'address3' => [
                            'type' => 'string',
                            'filters' => [
                                [
                                    'method' => 'substr',
                                    'args' => ['@value', '0', '28']
                                ]
                            ]
                        ],
                        'city' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'stateProvinceCode' => [
                            'type' => 'string'
                        ],
                        'countryCode' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'postalCode' => [
                            'type' => 'string',
                            'required' => true,
                            'filters' => [
                                [
                                    'method' => 'substr',
                                    'args' => ['@value', '0', '10']
                                ]
                            ]
                        ],
                    ]
                ],
            ]
        ],
        'GetItinerary' => [
            'extends' => 'AbstractOperation',
            'httpMethod' => 'GET',
            'uri' => '{+generalEndpoint}/ean-services/rs/hotel/v3/itin',
            'summary' => 'Retrieve the itinerary for an existing reservation',
            'documentationUrl' => 'https://dev.ean.com/docs/request-itinerary/',
            'responseModel' => 'ItineraryResponse',
            'data' => [
                'xmlRoot' => [
                    'name' => 'HotelItineraryRequest',
                ],
            ],
            'parameters' => [
                'itineraryId' => [
                    'location' => 'xml.query',
                    'type' => 'numeric',
                ],
                'affiliateConfirmationId' => [
                    'location' => 'xml.query',
                    'type' => 'string'
                ],
                'email' => [
                    'location' => 'xml.query',
                    'type' => 'string'
                ],
                'lastName' => [
                    'location' => 'xml.query',
                    'type' => 'string'
                ],
                'creditCardNumber' => [
                    'location' => 'xml.query',
                    'type' => 'string'
                ],
                'confirmationExtras' => [
                    'location' => 'xml.query',
                    'type' => 'string'
                ],
                'resendConfirmationEmail' => [
                    'location' => 'xml.query',
                    'type' => 'boolean'
                ],
                'ItineraryQuery' => [
                    'location' => 'xml.query',
                    'type' => 'object',
                    'properties' => [
                        'creationDateStart' => [
                            'type' => 'string',
                            'filters' => [
                                'Otg\Ean\Filter\StringFilter::formatUsDate'
                            ]
                        ],
                        'creationDateEnd' => [
                            'type' => 'string',
                            'filters' => [
                                'Otg\Ean\Filter\StringFilter::formatUsDate'
                            ]
                        ],
                        'departureDateStart' => [
                            'type' => 'string',
                            'filters' => [
                                'Otg\Ean\Filter\StringFilter::formatUsDate'
                            ]
                        ],
                        'departureDateEnd' => [
                            'type' => 'string',
                            'filters' => [
                                'Otg\Ean\Filter\StringFilter::formatUsDate'
                            ]
                        ],
                        'includeChildAffiliates' => [
                            'type' => 'boolean'
                        ]
                    ]
                ]
            ]
        ],
        'GetRoomCancellation' => [
            'extends' => 'AbstractOperation',
            'httpMethod' => 'GET',
            'uri' => '{+generalEndpoint}/ean-services/rs/hotel/v3/cancel',
            'summary' => 'Cancel a single room on an itinerary',
            'responseModel' => 'RoomCancellationResponse',
            'data' => [
                'xmlRoot' => [
                    'name' => 'HotelRoomCancellationRequest',
                ],
            ],
            'parameters' => [
                'itineraryId' => [
                    'location' => 'xml.query',
                    'type' => 'numeric',
                    'required' => true,
                ],
                'email' => [
                    'location' => 'xml.query',
                    'type' => 'string',
                    'required' => true,
                ],
                'confirmationNumber' => [
                    'location' => 'xml.query',
                    'type' => 'string',
                    'required' => true,
                ],
                'reason' => [
                    'location' => 'xml.query',
                    'type' => 'string'
                ]
            ],
        ],
        'GetRoomImages' => [
            'extends' => 'AbstractOperation',
            'httpMethod' => 'GET',
            'uri' => '{+generalEndpoint}/ean-services/rs/hotel/v3/roomImages',
            'summary' => 'Retrieve room-level photos for a specific property',
            'documentationUrl' => 'https://dev.ean.com/docs/room-images/',
            'responseModel' => 'RoomImagesResponse',
            'data' => [
                'xmlRoot' => [
                    'name' => 'HotelRoomImageRequest',
                ],
            ],
            'parameters' => [
                'hotelId' => [
                    'location' => 'xml.query',
                    'type' => 'numeric',
                    'required' => true
                ]
            ]
        ]
    ],
    'models' => [
        // extended by ChargeableRateInfo and ConvertedRateInfo
        'AbstractRateObject' => [
            'type' => 'object',
            'properties' => [
                'total' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                'surchargeTotal' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                'nightlyRateTotal' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                'maxNightlyRate' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                'currencyCode' => [
                    'type' => 'string',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                'commissionableUsdTotal' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                'averageRate' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                'averageBaseRate' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                // begin undocumented
                'grossProfitOnline' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                'grossProfitOffline' => [
                    'type' => 'numeric',
                    'data' => [
                        'xmlAttribute' => true
                    ]
                ],
                // end undocumented
                'NightlyRates' => [
                    'type' => 'array',
                    'sentAs' => 'NightlyRatesPerRoom',
                    'items' => [
                        'sentAs' => 'NightlyRate',
                        'type' => 'object',
                        'properties' => [
                            'promo' => [
                                'type' => 'boolean',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ],
                            'rate' => [
                                'type' => 'numeric',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ],
                            'baseRate' => [
                                'type' => 'numeric',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ],
                        ]
                    ]
                ],
                'Surcharges' => [
                    'type' => 'array',
                    'items' => [
                        'sentAs' => 'Surcharge',
                        'type' => 'object',
                        'properties' => [
                            'amount' => [
                                'type' => 'numeric',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ],
                            'type' => [
                                'type' => 'string',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'AbstractCancelPolicyInfoList' => [
            'type' => 'array',
            'items' => [
                'sentAs' => 'CancelPolicyInfo',
                'type' => 'object',
                'properties' => [
                    'versionId' => [
                        'type' => 'numeric'
                    ],
                    'cancelTime' => [
                        'type' => 'string'
                    ],
                    'startWindowHours' => [
                        'type' => 'string'
                    ],
                    'nightCount' => [
                        'type' => 'string'
                    ],
                    'percent' => [
                        'type' => 'string'
                    ],
                    'amount' => [
                        'type' => 'string'
                    ],
                    'currencyCode' => [
                        'type' => 'string'
                    ],
                    'timeZoneDescription' => [
                        'type' => 'string'
                    ],
                ]
            ]
        ],
        'AbstractHotelFees' => [
            'type' => 'array',
            'items' => [
                'sentAs' => 'HotelFee',
                'type' => 'object',
                'properties' => [
                    'description' => [
                        'type' => 'string',
                        'data' => [
                            'xmlAttribute' => true
                        ]
                    ],
                    'amount' => [
                        'type' => 'numeric',
                        'data' => [
                            'xmlAttribute' => true
                        ]
                    ],
                    'HotelFeeBreakdown' => [
                        'type' => 'object',
                        'properties' => [
                            'unit' => [
                                'type' => 'string',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ],
                            'frequency' => [
                                'type' => 'string',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'AbstractBedTypes' => [
            'type' => 'array',
            'items' => [
                'type' => 'object',
                'sentAs' => 'BedType',
                'properties' => [
                    'id' => [
                        'data' => [
                            'xmlAttribute' => true
                        ]
                    ],
                    'description' => [
                        'type' => 'string'
                    ]
                ]
            ],
            'filters' => [
                [
                    'method' => 'Otg\Ean\Filter\ArrayFilter::reIndex',
                    'args' => ['@value', 'id', 'description']
                ]
            ]
        ],
        'AbstractValueAdds' => [
            'type' => 'array',
            'items' => [
                'type' => 'object',
                'sentAs' => 'ValueAdd',
                'properties' => [
                    'description' => [
                        'type' => 'string'
                    ]
                ]
            ]
        ],
        'AbstractRateInfos' => [
            'type' => 'array',
            'items' => [
                'sentAs' => 'RateInfo',
                'type' => 'object',
                'properties' => [
                    'priceBreakdown' => [
                        'type' => 'boolean',
                        'data' => [
                            'xmlAttribute' => true
                        ]
                    ],
                    'promo' => [
                        'type' => 'boolean',
                        'data' => [
                            'xmlAttribute' => true
                        ]
                    ],
                    'rateChange' => [
                        'type' => 'boolean',
                        'data' => [
                            'xmlAttribute' => true
                        ]
                    ],
                    'promoId' => [
                        'type' => 'string'
                    ],
                    'promoDescription' => [
                        'type' => 'string'
                    ],
                    'promoDetailText' => [
                        'type' => 'string'
                    ],
                    'nonRefundable' => [
                        'type' => 'boolean'
                    ],
                    'depositRequired' => [
                        'type' => 'boolean'
                    ],
                    'rateType' => [
                        'type' => 'string'
                    ],
                    'currentAllotment' => [
                        'type' => 'numeric'
                    ],
                    'cancellationPolicy' => [
                        'type' => 'string'
                    ],
                    'CancelPolicyInfoList' => [
                        'extends' => 'AbstractCancelPolicyInfoList'
                    ],
                    'ChargeableRateInfo' => [
                        'extends' => 'AbstractRateObject'
                    ],
                    'ConvertedRateInfo' => [
                        'extends' => 'AbstractRateObject'
                    ],
                    'RoomGroup' => [
                        'type' => 'array',
                        'items' => [
                            'type' => 'object',
                            'sentAs' => 'Room',
                            'properties' => [
                                'numberOfAdults' => [
                                    'type' => 'numeric',
                                ],
                                'numberOfChildren' => [
                                    'type' => 'numeric',
                                ],
                                'childAges' => [
                                    'type' => 'string'
                                ],
                                'rateKey' => [
                                    'type' => 'string'
                                ]
                            ]
                        ]
                    ],
                    'promoType' => [
                        'type' => 'string'
                    ],
                    'HotelFees' => [
                        'extends' => 'AbstractHotelFees'
                    ]
                ]
            ]
        ],
        'HotelListResponse' => [
            'type' => 'object',
            'properties' => [
                'moreResultsAvailable' => [
                    'location' => 'xml',
                    'type' => 'boolean'
                ],
                'numberOfRoomsRequested' => [
                    'location' => 'xml',
                    'type' => 'numeric'
                ],
                'cacheKey' => [
                    'location' => 'xml',
                    'type' => 'string'
                ],
                'cacheLocation' => [
                    'location' => 'xml',
                    'type' => 'string'
                ],
                'HotelList' => [
                    'location' => 'xml',
                    'type' => 'array',
                    'items' => [
                        'sentAs' => 'HotelSummary',
                        'type' => 'object',
                        'properties' => [
                            'tripAdvisorRating' => [
                                'type' => 'string'
                            ],
                            'tripAdvisorReviewCount' => [
                                'type' => 'numeric'
                            ],
                            'tripAdvisorRatingUrl' => [
                                'type' => 'string'
                            ],
                            'hotelId' => [
                                'type' => 'numeric'
                            ],
                            'name' => [
                                'type' => 'string'
                            ],
                            'address1' => [
                                'type' => 'string'
                            ],
                            'city' => [
                                'type' => 'string'
                            ],
                            'stateProvinceCode' => [
                                'type' => 'string'
                            ],
                            'countryCode' => [
                                'type' => 'string'
                            ],
                            'postalCode' => [
                                'type' => 'string'
                            ],
                            'airportCode' => [
                                'type' => 'string'
                            ],
                            'supplierType' => [
                                'type' => 'string'
                            ],
                            'propertyCategory' => [
                                'type' => 'string'
                            ],
                            'hotelRating' => [
                                'type' => 'string'
                            ],
                            'amenityMask' => [
                                'type' => 'numeric'
                            ],
                            'shortDescription' => [
                                'type' => 'string'
                            ],
                            'locationDescription' => [
                                'type' => 'string'
                            ],
                            'lowRate' => [
                                'type' => 'string'
                            ],
                            'highRate' => [
                                'type' => 'string'
                            ],
                            'rateCurrencyCode' => [
                                'type' => 'string'
                            ],
                            'latitude' => [
                                'type' => 'string'
                            ],
                            'longitude' => [
                                'type' => 'string'
                            ],
                            'proximityDistance' => [
                                'type' => 'string'
                            ],
                            'proximityUnit' => [
                                'type' => 'string'
                            ],
                            'hotelInDestination' => [
                                'type' => 'boolean'
                            ],
                            'thumbNailUrl' => [
                                'type' => 'string'
                            ],
                            'deepLink' => [
                                'type' => 'string'
                            ],
                            'RoomRateDetailsList' => [
                                'type' => 'array',
                                'items' => [
                                    'sentAs' => 'RoomRateDetails',
                                    'type' => 'object',
                                    'properties' => [
                                        'roomTypeCode' => [
                                            'type' => 'string'
                                        ],
                                        'rateCode' => [
                                            'type' => 'string'
                                        ],
                                        'maxRoomOccupancy' => [
                                            'type' => 'numeric'
                                        ],
                                        'quotedRoomOccupancy' => [
                                            'type' => 'numeric'
                                        ],
                                        'minGuestAge' => [
                                            'type' => 'numeric'
                                        ],
                                        'roomDescription' => [
                                            'type' => 'string'
                                        ],
                                        'promoId' => [
                                            'type' => 'string'
                                        ],
                                        'promoDescription' => [
                                            'type' => 'string'
                                        ],
                                        'promoDetailText' => [
                                            'type' => 'string'
                                        ],
                                        'currentAllotment' => [
                                            'type' => 'numeric'
                                        ],
                                        'propertyAvailable' => [
                                            'type' => 'boolean'
                                        ],
                                        'propertyRestricted' => [
                                            'type' => 'boolean'
                                        ],
                                        'expediaPropertyId' => [
                                            'type' => 'string'
                                        ],
                                        'BedTypes' => [
                                            'extends' => 'AbstractBedTypes'
                                        ],
                                        'rateKey' => [
                                            'type' => 'string'
                                        ],
                                        'smokingPreferences' => [
                                            'type' => 'string'
                                        ],
                                        'nonRefundable' => [
                                            'type' => 'boolean'
                                        ],
                                        'ValueAdds' => [
                                            'extends' => 'AbstractValueAdds'
                                        ],
                                        'RateInfos' => [
                                            'extends' => 'AbstractRateInfos'
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ]
                ],
                'cachedSupplierResponse' => [
                    'location' => 'xml',
                    'type' => 'object',
                    'properties' => [
                        'cacheEntryHitNum' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'cacheEntryMissNum' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'cacheEntryExpiredNum' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'cacheRetrievalTime' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'supplierRequestNum' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'supplierResponseNum' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'supplierResponseTime' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'candidatePrepTime' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'otherOverheadTime' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'tpidUsed' => [
                            'type' => 'numeric',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'matchedCurrency' => [
                            'type' => 'boolean',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'matchedLocale' => [
                            'type' => 'boolean',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'extrapolatedCurrency' => [
                            'type' => 'boolean',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ],
                        'extrapolatedLocale' => [
                            'type' => 'boolean',
                            'data' => [
                                'xmlAttribute' => true
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'RoomAvailabilityResponse' => [
            'type' => 'object',
            'properties' => [
                'hotelId' => [
                    'location' => 'xml',
                    'type' => 'numeric',
                ],
                'arrivalDate' => [
                    'location' => 'xml'
                ],
                'departureDate' => [
                    'location' => 'xml'
                ],
                'hotelName' => [
                    'location' => 'xml'
                ],
                'hotelAddress' => [
                    'location' => 'xml'
                ],
                'hotelCity' => [
                    'location' => 'xml'
                ],
                'hotelStateProvince' => [
                    'location' => 'xml'
                ],
                'hotelCountry' => [
                    'location' => 'xml'
                ],
                'numberOfRoomsRequested' => [
                    'location' => 'xml'
                ],
                'checkInInstructions' => [
                    'location' => 'xml'
                ],
                'tripAdvisorRating' => [
                    'type' => 'string'
                ],
                'tripAdvisorReviewCount' => [
                    'type' => 'numeric'
                ],
                'tripAdvisorRatingUrl' => [
                    'type' => 'string'
                ],
                'Rooms' => [
                    'sentAs' => 'HotelRoomResponse',
                    'location' => 'xml',
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'policy' => [
                                'type' => 'string',
                            ],
                            'rateCode' => [
                                'type' => 'string'
                            ],
                            'roomTypeCode' => [
                                'type' => 'string',
                            ],
                            'rateDescription' => [
                                'type' => 'string',
                            ],
                            'roomTypeDescription' => [
                                'type' => 'string',
                            ],
                            'supplierType' => [
                                'type' => 'string',
                            ],
                            'otherInformation' => [
                                'type' => 'string',
                            ],
                            'propertyId' => [
                                'type' => 'string',
                            ],
                            'smokingPreferences' => [
                                'type' => 'string',
                            ],
                            'minGuestAge' => [
                                'type' => 'numeric',
                            ],
                            'quotedOccupancy' => [
                                'type' => 'numeric',
                            ],
                            'rateOccupancyPerRoom' => [
                                'type' => 'numeric',
                            ],
                            'deepLink' => [
                                'type' => 'string',
                            ],
                            'BedTypes' => [
                                'extends' => 'AbstractBedTypes'
                            ],
                            'ValueAdds' => [
                                'extends' => 'AbstractValueAdds'
                            ],
                            'RoomImages' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'sentAs' => 'RoomImage',
                                    'properties' => [
                                        'url' => [
                                            'type' => 'string'
                                        ]
                                    ]
                                ]
                            ],
                            'RoomType' => [
                                'type' => 'object',
                                'properties' => [
                                    'roomCode' => [
                                        'data' => [
                                            'xmlAttribute' => true
                                        ]
                                    ],
                                    'roomTypeId' => [
                                        'data' => [
                                            'xmlAttribute' => true
                                        ]
                                    ],
                                    'description' => [
                                        'type' => 'string'
                                    ],
                                    'descriptionLong' => [
                                        'type' => 'string'
                                    ],
                                    'RoomAmenities' => [
                                        // todo: extend from abstract model (shared with HotelInfo model]
                                        'type' => 'array',
                                        'sentAs' => 'roomAmenities',
                                        'items' => [
                                            'sentAs' => 'RoomAmenity',
                                            'type' => 'object',
                                            'properties' => [
                                                'amenityId' => [
                                                    'data' => [
                                                        'xmlAttribute' => true
                                                    ]
                                                ],
                                                'amenity' => [
                                                    'type' => 'string'
                                                ]
                                            ]
                                        ]
                                    ],
                                    'HotelDetails' => [
                                        // todo: extend from abstract model (shared with HotelInfo model]
                                        'type' => 'object'
                                    ],
                                    'PropertyAmenities' => [
                                        // todo: extend from abstract model (shared with HotelInfo model]
                                        'type' => 'array',
                                        'items' => [
                                            'sentAs' => 'PropertyAmenity',
                                            'type' => 'object',
                                            'properties' => [
                                                'amenityId' => [
                                                    'data' => [
                                                        'xmlAttribute' => true
                                                    ]
                                                ],
                                                'amenity' => [
                                                    'type' => 'string'
                                                ]
                                            ]
                                        ]
                                    ],
                                    'HotelImages' => [
                                        // todo: extend from abstract model (shared with HotelInfo model]
                                        'type' => 'array',
                                        'items' => [
                                            'sentAs' => 'HotelImage',
                                            'type' => 'object',
                                            'properties' => [
                                                'hotelImageId' => [
                                                    'type' => 'numeric',
                                                ],
                                                'name' => [
                                                    'type' => 'string'
                                                ],
                                                'category' => [
                                                    'type' => 'numeric'
                                                ],
                                                'type' => [
                                                    'type' => 'numeric',
                                                ],
                                                'caption' => [
                                                    'type' => 'string'
                                                ],
                                                'url' => [
                                                    'type' => 'string'
                                                ],
                                                'thumbnailUrl' => [
                                                    'type' => 'string'
                                                ],
                                                'supplierId' => [
                                                    'type' => 'numeric'
                                                ],
                                                'width' => [
                                                    'type' => 'numeric'
                                                ],
                                                'height' => [
                                                    'type' => 'numeric'
                                                ],
                                                'byteSize' => [
                                                    'type' => 'numeric'
                                                ],
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'RateInfos' => [
                                'extends' => 'AbstractRateInfos'
                            ]
                        ],
                    ]
                ],
            ]
        ],
        'ReservationResponse' => [
            'type' => 'object',
            'properties' => [
                'itineraryId' => [
                    'location' => 'xml',
                    'type' => 'numeric'
                ],
                'confirmationNumbers' => [
                    'location' => 'xml',
                    'type' => 'array',
                    'items' => [
                        'type' => 'numeric'
                    ]
                ],
                'processedWithConfirmation' => [
                    'location' => 'xml',
                    'type' => 'boolean'
                ],
                'errorText' => [
                    'location' => 'xml',
                ],
                'hotelReplyText' => [
                    'location' => 'xml',
                ],
                'supplierType' => [
                    'location' => 'xml',
                ],
                'reservationStatusCode' => [
                    'location' => 'xml',
                ],
                'existingItinerary' => [
                    'location' => 'xml',
                    'type' => 'boolean'
                ],
                'numberOfRoomsBooked' => [
                    'location' => 'xml',
                    'type' => 'numeric'
                ],
                'drivingDirections' => [
                    'location' => 'xml',
                ],
                'checkInInstructions' => [
                    'location' => 'xml',
                ],
                'arrivalDate' => [
                    'location' => 'xml',
                ],
                'departureDate' => [
                    'location' => 'xml',
                ],
                'hotelName' => [
                    'location' => 'xml',
                ],
                'hotelAddress' => [
                    'location' => 'xml',
                ],
                'hotelCity' => [
                    'location' => 'xml',
                ],
                'hotelStateProvinceCode' => [
                    'location' => 'xml',
                ],
                'hotelCountryCode' => [
                    'location' => 'xml',
                ],
                'hotelPostalCode' => [
                    'location' => 'xml',
                ],
                'roomDescription' => [
                    'location' => 'xml',
                ],
                'rateOccupancyPerRoom' => [
                    'location' => 'xml',
                    'type' => 'numeric'
                ],
                'RateInfos' => [
                    'location' => 'xml',
                    'type' => 'array',
                    'items' => [
                        'sentAs' => 'RateInfo',
                        'type' => 'object',
                        'properties' => [
                            'priceBreakdown' => [
                                'type' => 'boolean',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ],
                            'promo' => [
                                'type' => 'boolean',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ],
                            'rateChange' => [
                                'type' => 'boolean',
                                'data' => [
                                    'xmlAttribute' => true
                                ]
                            ],
                            'cancellationPolicy' => [
                                'type' => 'string'
                            ],
                            'CancelPolicyInfoList' => [
                                'extends' => 'AbstractCancelPolicyInfoList'
                            ],
                            'nonRefundable' => [
                                'type' => 'boolean'
                            ],
                            'ChargeableRateInfo' => [
                                'extends' => 'AbstractRateObject'
                            ],
                            'ConvertedRateInfo' => [
                                'extends' => 'AbstractRateObject'
                            ],
                            'promoType' => [
                                'type' => 'string'
                            ],
                            'depositRequired' => [
                                'type' => 'boolean'
                            ],
                            'rateType' => [
                                'type' => 'string'
                            ],
                            'HotelFees' => [
                                'extends' => 'AbstractHotelFees'
                            ],
                            'RoomGroup' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'sentAs' => 'Room',
                                    'properties' => [
                                        'numberOfAdults' => [
                                            'type' => 'numeric'
                                        ],
                                        'numberOfChildren' => [
                                            'type' => 'numeric'
                                        ],
                                        'childAges' => [
                                            'type' => 'string'
                                        ],
                                        'firstName' => [
                                            'type' => 'string'
                                        ],
                                        'lastName' => [
                                            'type' => 'string'
                                        ],
                                        'bedTypeId' => [
                                            'type' => 'string'
                                        ],
                                        'bedTypeDescription' => [
                                            'type' => 'string'
                                        ],
                                        'numberOfBeds' => [
                                            'type' => 'numeric'
                                        ],
                                        'smokingPreference' => [
                                            'type' => 'string'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'ItineraryResponse' => [
            'type' => 'object',
            'properties' => [
                'customerSessionId' => [
                    'location' => 'xml',
                    'type' => 'string'
                ],
                'Itinerary' => [
                    'location' => 'xml',
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'itineraryId' => [
                                'type' => 'numeric'
                            ],
                            'affiliateId' => [
                                'type' => 'numeric'
                            ],
                            'creationDate' => [
                                'type' => 'string'
                            ],
                            'itineraryStartDate' => [
                                'type' => 'string'
                            ],
                            'itineraryEndDate' => [
                                'type' => 'string'
                            ],
                            'affiliateCustomerId' => [
                                'type' => 'string'
                            ],
                            'Customer' => [
                                'type' => 'object',
                                'properties' => [
                                    'email' => [
                                        'type' => 'string'
                                    ],
                                    'firstName' => [
                                        'type' => 'string'
                                    ],
                                    'lastName' => [
                                        'type' => 'string'
                                    ],
                                    'homePhone' => [
                                        'type' => 'string'
                                    ],
                                    'workPhone' => [
                                        'type' => 'string'
                                    ],
                                    'extension' => [
                                        'type' => 'string'
                                    ],
                                    'faxPhone' => [
                                        'type' => 'string'
                                    ],
                                    'CustomerAddresses' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'address1' => [
                                                'type' => 'string'
                                            ],
                                            'address2' => [
                                                'type' => 'string'
                                            ],
                                            'address3' => [
                                                'type' => 'string'
                                            ],
                                            'city' => [
                                                'type' => 'string'
                                            ],
                                            'stateProvinceCode' => [
                                                'type' => 'string'
                                            ],
                                            'countryCode' => [
                                                'type' => 'string'
                                            ],
                                            'postalCode' => [
                                                'type' => 'string'
                                            ],
                                            'isPrimary' => [
                                                'type' => 'boolean'
                                            ],
                                            'type' => [
                                                'type' => 'numeric'
                                            ]
                                        ]
                                    ],

                                ]
                            ],
                            'HotelConfirmation' => [
                                'type' => 'object',
                                'properties' => [
                                    'supplierId' => [
                                        'type' => 'string'
                                    ],
                                    'chainCode' => [
                                        'type' => 'string'
                                    ],
                                    'creditCardType' => [
                                        'type' => 'string'
                                    ],
                                    'arrivalDate' => [
                                        'type' => 'string'
                                    ],
                                    'departureDate' => [
                                        'type' => 'string'
                                    ],
                                    'confirmationNumber' => [
                                        'type' => 'string'
                                    ],
                                    'cancellationNumber' => [
                                        'type' => 'string'
                                    ],
                                    'numberOfAdults' => [
                                        'type' => 'numeric'
                                    ],
                                    'numberOfChildren' => [
                                        'type' => 'numeric'
                                    ],
                                    'affiliateConfirmationId' => [
                                        'type' => 'string'
                                    ],
                                    'smokingPreference' => [
                                        'type' => 'string'
                                    ],
                                    'supplierPropertyId' => [
                                        'type' => 'string'
                                    ],
                                    'roomTypeCode' => [
                                        'type' => 'string'
                                    ],
                                    'rateCode' => [
                                        'type' => 'string'
                                    ],
                                    'rateDescription' => [
                                        'type' => 'string'
                                    ],
                                    'roomDescription' => [
                                        'type' => 'string'
                                    ],
                                    'status' => [
                                        'type' => 'string'
                                    ],
                                    'locale' => [
                                        'type' => 'string'
                                    ],
                                    'nights' => [
                                        'type' => 'numeric'
                                    ],
                                    'GenericRefund' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'refundAmount' => [
                                                'type' => 'string'
                                            ],
                                            'currencyCode' => [
                                                'type' => 'string'
                                            ]
                                        ]
                                    ],
                                    'RateInfos' => [
                                        'extends' => 'AbstractRateInfos'
                                    ],
                                    'ReservationGuest' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'firstName' => [
                                                'type' => 'string'
                                            ],
                                            'lastName' => [
                                                'type' => 'string'
                                            ]
                                        ]
                                    ],
                                    'Hotel' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'hotelId' => [
                                                'type' => 'numeric'
                                            ],
                                            'statusCode' => [
                                                'type' => 'string'
                                            ],
                                            'name' => [
                                                'type' => 'string'
                                            ],
                                            'address1' => [
                                                'type' => 'string'
                                            ],
                                            'address2' => [
                                                'type' => 'string'
                                            ],
                                            'address3' => [
                                                'type' => 'string'
                                            ],
                                            'city' => [
                                                'type' => 'string'
                                            ],
                                            'stateProvinceCode' => [
                                                'type' => 'string'
                                            ],
                                            'countryCode' => [
                                                'type' => 'string'
                                            ],
                                            'postalCode' => [
                                                'type' => 'string'
                                            ],
                                            'phone' => [
                                                'type' => 'string'
                                            ],
                                            'fax' => [
                                                'type' => 'string'
                                            ],
                                            'latitude' => [
                                                'type' => 'string'
                                            ],
                                            'longitude' => [
                                                'type' => 'string'
                                            ],
                                            'coordinateAccuracyCode' => [
                                                'type' => 'string'
                                            ],
                                            'lowRate' => [
                                                'type' => 'string'
                                            ],
                                            'highRate' => [
                                                'type' => 'string'
                                            ],
                                            'hotelRating' => [
                                                'type' => 'string'
                                            ],
                                            'tripAdvisorRating' => [
                                                'type' => 'string'
                                            ],
                                            'market' => [
                                                'type' => 'string'
                                            ],
                                            'region' => [
                                                'type' => 'string'
                                            ],
                                            'superRegion' => [
                                                'type' => 'string'
                                            ],
                                            'theme' => [
                                                'type' => 'string'
                                            ]
                                        ]
                                    ],
                                    'ConfirmationExtras' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'sentAs' => 'ConfirmationExtra',
                                            'properties' => [
                                                'name' => [
                                                    'type' => 'string'
                                                ],
                                                'value' => [
                                                    'type' => 'string'
                                                ]
                                            ]
                                        ]
                                    ],
                                    'ValueAdds' => [
                                        'extends' => 'AbstractValueAdds'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'RoomCancellationResponse' => [
            'type' => 'object',
            'properties' => [
                'cancellationNumber' => [
                    'location' => 'xml',
                    'type' => 'string'
                ],
                'customerSessionId' => [
                    'location' => 'xml',
                    'type' => 'string'
                ]
            ]
        ],
        'RoomImagesResponse' => [
            'type' => 'object',
            'properties' => [
                'RoomImages' => [
                    'location' => 'xml',
                    'type' => 'array',
                    'items' => [
                        'sentAs' => 'RoomImage',
                        'type' => 'object',
                        'properties' => [
                            'roomTypeCode' => [
                                'type' => 'string'
                            ],
                            'url' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
