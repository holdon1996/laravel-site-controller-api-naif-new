<?php

return [
    'api_key' => env('SC_API_KEY'),
    'is_write_log' => true, // config write log default of package
    'tllincoln' => [
        'booking_handler' => \ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln\TlLincolnSoapService::class,
        'mapping_data_handler' => \ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln\TlLincolnMappingService::class,
    ],
    'tllincoln_api' => [
        'date_format' => 'Y-m-d',
        'time_format' => 'h:i:s',
        'get_empty_room_series_url' => env('SC_TLLINCOLN_URL_SOAP_API') . 'RoomAndPlanInquirySalesStsService',
        'get_empty_room_url' =>  env('SC_TLLINCOLN_URL_SOAP_API') . 'RoomAndPlanInquirySalesStsService',
        'get_plan_price_url' =>  env('SC_TLLINCOLN_URL_SOAP_API') . 'RoomAndPlanInquirySalesStsService',
        'get_plan_price_series_url' =>  env('SC_TLLINCOLN_URL_SOAP_API') . 'RoomAndPlanInquiryAnyUnitPriceSalesStsService',
        'check_pre_booking_url' =>  env('SC_TLLINCOLN_URL_SOAP_API') . 'ReservationControlService',
        'entry_booking_url' =>  env('SC_TLLINCOLN_URL_SOAP_API') . 'ReservationControlService',
        'cancel_booking_url' =>  env('SC_TLLINCOLN_URL_SOAP_API') . 'ReservationControlServiceWithCP',
        'command_cancel_booking' => env('SC_TLLINCOLN_URL_SOAP_API') . 'deleteBookingWithCP',
        'get_master_url' => env('SC_TLLINCOLN_MASTER_DOWNLOAD_URL'),
        'get_partial_url' => env('SC_TLLINCOLN_PARTIAL_DOWNLOAD_URL'),
        'search_room_type' => 'search_room_type',
        'search_plan' => 'search_plan',
        'search_read_option' => 'search_read_option',
        'hotel_avail' => 'hotel_avail',
        'hotel_description' => 'hotel_avail',
        'api_file_type_const' => [
            'file_master_hotel' => 11,
            'file_master_room_type' => 12,
            'file_master_plan' => 13,
            'file_diff_master_room_type' => 22,
            'file_diff_master_plan' => 23,
            'file_diff_empty_room' => 24,
            'file_diff_price_plan' => 28,
        ],
        'api_search_type_const' => [
            'new' => 1,
            'by_date' => 2,
            'by_file_number' => 3
        ],
        'get_empty_room_max_day' => 30,
        'tllincoln_date_format_api' => 'Ymd',
        'system_format_time' => 'h:m:s',
        'empty_room_max_month' => 13,
        'xml' => [
            'xmlns_type' => 'naif', // TODO change if use other
            'naif' => [
                'code' => 'naif',
                'naif_common' => [
                    'url' => 'http://naifc1000.naifc10.nai.lincoln.seanuts.co.jp/',
                ],
                'naif_booking' => [
                    'url' => 'http://naifc3000.naifc30.nai.lincoln.seanuts.co.jp/',
                ],
                'naif_6000' => [
                    'url' => 'http://naifc6000.naifc60.nai.lincoln.seanuts.co.jp/',
                ],
            ]
        ],
        'result_code_xml' => [
            'success' => 'True',
            'fail' => 'False',
        ],
        'mapping_plan_tllincoln' => 0,
        'not_mapping_plan_tllincoln' => 1,
        'sales_office_code' => 1001, //TODO change
        'sales_office_name' => 'Test', //TODO change
        'using_plan_tllincoln' => 0,
    ],
    'file_xsd_patch' => 'app/helper/xsd/',
];
