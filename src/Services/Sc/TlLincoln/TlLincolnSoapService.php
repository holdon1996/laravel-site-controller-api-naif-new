<?php

namespace ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln;

use ThachVd\LaravelSiteControllerApi\Models\ScTlLincolnSoapApiLog;
use ThachVd\LaravelSiteControllerApi\Models\TllincolnAccount;
use ThachVd\LaravelSiteControllerApi\Services\Sc\Xml2Array\Xml2Array;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln\FormatSoapArrayBody;

/**
 *
 */
class TlLincolnSoapService
{
    /**
     * @var TlLincolnSoapClient
     */
    protected $tlLincolnSoapClient;
    /**
     * @var TlLincolnSoapBody
     */
    protected $tlLincolnSoapBody;
    /**
     * @var FormatSoapArrayBody
     */
    protected $formatSoapArrayBody;

    /**
     * @param TlLincolnSoapClient $tlLincolnSoapClient
     * @param TlLincolnSoapBody $tlLincolnSoapBody
     * @param FormatSoapArrayBody $formatSoapArrayBody
     */
    public function __construct(
        TlLincolnSoapClient $tlLincolnSoapClient, 
        TlLincolnSoapBody $tlLincolnSoapBody,
        FormatSoapArrayBody $formatSoapArrayBody
    )
    {
        $this->tlLincolnSoapClient = $tlLincolnSoapClient;
        $this->tlLincolnSoapBody   = $tlLincolnSoapBody;
        $this->formatSoapArrayBody   = $formatSoapArrayBody;
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEmptyRoom(Request $request)
    {
        $isWriteLog     = config('sc.is_write_log');
        $dateValidation = $this->validateAndParseDates($request);
        if (isset($dateValidation['success']) && !$dateValidation['success']) {
            return $dateValidation;
        }

        $command = 'roomAvailabilitySalesSts';
        // set body request
        $this->setEmptyRoomSoapRequest($dateValidation, $request, $command);

        try {
            $url        = config('sc.tllincoln_api.get_empty_room_url');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $this->tlLincolnSoapClient->getBody(),
            ];
            $response   = $this->tlLincolnSoapClient->callSoapApi($url);

            $data    = [];
            $success = true;

            if ($response !== null) {
                $rooms = $this->tlLincolnSoapClient->convertResponeToArray($response);

                if (isset($rooms['ns2:roomAvailabilitySalesStsResponse']['roomAvailabilitySalesStsResult']['hotelInfos'])) {
                    $data = $rooms['ns2:roomAvailabilitySalesStsResponse']['roomAvailabilitySalesStsResult']['hotelInfos'];
                }
            } else {
                $success = false;
            }
            if ($isWriteLog) {
                $soapApiLog['response']   = $response;
                $soapApiLog['is_success'] = $success;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success'     => $success,
                'data'        => $data,
                'xmlResponse' => $response
            ]);
        } catch (\Exception $e) {
            if ($isWriteLog) {
                $soapApiLog['response']   = $e->getMessage();
                $soapApiLog['is_success'] = false;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBulkEmptyRoom(Request $request)
    {
        $command = 'roomAvailabilityAllSalesSts';
        // set body request
        $this->setBulkEmptyRoomSoapRequest($request, $command);
        try {
            $url        = config('sc.tllincoln_api.get_empty_room_series_url');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $this->tlLincolnSoapClient->getBody(),
            ];

            $response = $this->tlLincolnSoapClient->callSoapApi($url);

            $data    = [];
            $success = true;

            if ($response !== null) {
                $arrRooms = $this->tlLincolnSoapClient->convertResponeToArray($response);

                if (isset($arrRooms['ns2:roomAvailabilityAllSalesStsResponse']['roomAvailabilityAllSalesStsResult']['hotelInfos'])) {
                    $data = $arrRooms['ns2:roomAvailabilityAllSalesStsResponse']['roomAvailabilityAllSalesStsResult']['hotelInfos'];
                }
            } else {
                $success = false;
            }

            $soapApiLog['response']   = $response;
            $soapApiLog['is_success'] = $success;
            ScTlLincolnSoapApiLog::createLog($soapApiLog);

            return response()->json([
                'success' => $success,
                'data'    => $data,
                'date'    => now()->format(config('sc.tllincoln_api.date_format')),
            ]);
        } catch (\Exception $e) {
            $soapApiLog['response']   = $e->getMessage();
            $soapApiLog['is_success'] = false;
            ScTlLincolnSoapApiLog::createLog($soapApiLog);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPricePlan(Request $request)
    {
        $isWriteLog     = config('sc.is_write_log');
        $dateValidation = $this->validateAndParseDates($request);
        if (isset($dateValidation['success']) && !$dateValidation['success']) {
            return $dateValidation;
        }

        $command = 'planPriceInfoAcquisition';
        // set body request
        $this->setPricePlanSoapRequest($dateValidation, $request, $command);

        try {
            $url        = config('sc.tllincoln_api.get_plan_price_url');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $this->tlLincolnSoapClient->getBody(),
            ];
            $response   = $this->tlLincolnSoapClient->callSoapApi($url);
            $data       = [];
            $success    = true;

            if ($response !== null) {
                $arrPlans = $this->tlLincolnSoapClient->convertResponeToArray($response);
                if (isset($arrPlans['ns2:planPriceInfoAcquisitionResponse']['planPriceInfoResult']['hotelInfos'])) {
                    $data = $arrPlans['ns2:planPriceInfoAcquisitionResponse']['planPriceInfoResult']['hotelInfos'];
                }
            } else {
                $success = false;
            }

            if ($isWriteLog) {
                $soapApiLog['response']   = $response;
                $soapApiLog['is_success'] = $success;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success'     => $success,
                'data'        => $data,
                'xmlResponse' => $response
            ]);
        } catch (\Exception $e) {
            if ($isWriteLog) {
                $soapApiLog['response']   = $e->getMessage();
                $soapApiLog['is_success'] = false;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBulkPricePlan(Request $request)
    {
        $command = 'planPriceInfoAcquisitionAll';
        // set body request
        $this->setBulkPricePlanSoapRequest($request, $command);

        try {
            $url        = config('sc.tllincoln_api.get_plan_price_series_url');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $this->tlLincolnSoapClient->getBody(),
            ];
            $response   = $this->tlLincolnSoapClient->callSoapApi($url);
            $data       = [];
            $success    = true;

            if ($response !== null) {
                $arrPrices = $this->tlLincolnSoapClient->convertResponeToArray($response);
                if (isset($arrPrices['ns2:planPriceInfoAcquisitionAllResponse']['planPriceInfoAllResult']['hotelInfos'])) {
                    $data = $arrPrices['ns2:planPriceInfoAcquisitionAllResponse']['planPriceInfoAllResult']['hotelInfos'];
                }
            } else {
                $success = false;
            }

            $soapApiLog['response']   = $response;
            $soapApiLog['is_success'] = $success;
            ScTlLincolnSoapApiLog::createLog($soapApiLog);

            return response()->json([
                'success' => $success,
                'data'    => $data,
                'date'    => now()->format(config('sc.tllincoln_api.date_format')),
            ]);
        } catch (\Exception $e) {
            $soapApiLog['response']   = $e->getMessage();
            $soapApiLog['is_success'] = false;
            ScTlLincolnSoapApiLog::createLog($soapApiLog);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    public function createBooking(Request $request)
    {
        // precheck create booking
        $preCheckBookingResponse = $this->preCheckCreateBooking($request);
        //TODO check preCheckBookingResponse success

        // entry booking
        $entryBookingResponse = $this->entryBooking($request);
        // TODO check entryBookingResponse success
        // TODO return response to client
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function preCheckCreateBooking($request)
    {
        $url     = config('sc.tllincoln_api.check_pre_booking_url');
        $command = 'preBooking';

        $dataRequest = $this->formatSoapArrayBody->getArrayEntryBookingBody($request);

        $response = $this->processBooking($url, $command, $dataRequest);

        return $response;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function entryBooking($request)
    {
        $url     = config('sc.tllincoln_api.entry_booking_url');
        $command = 'entryBooking';

        $dataRequest = $this->formatSoapArrayBody->getArrayEntryBookingBody($request);

        $response = $this->processBooking($url, $command, $dataRequest);

        return $response;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function cancelBooking($request)
    {
        $url     = config('sc.tllincoln_api.cancel_booking_url');
        $command = 'deleteBookingWithCP';

        $dataRequest = $this->formatSoapArrayBody->getArrayCancelBookingBody($request);

        $response = $this->processBooking($url, $command, $dataRequest);

        return $response;
    }

    /**
     * @param $url
     * @param $command
     * @param $request
     * @return mixed
     */
    public function processBooking($url, $command, $request)
    {
        $naifVersion = config('sc.tllincoln_api.xml.xmlns_type') . '_booking';
        $this->setSoapRequest($request, $command, $naifVersion);
        try {
            $isWriteLog = config('sc.is_write_log');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $this->tlLincolnSoapClient->getBody(),
            ];
            $response   = $this->tlLincolnSoapClient->callSoapApi($url);
            $data       = [];
            $success    = true;
            $message    = ["TL エラー:"];

            if ($response !== null) {
                $data           = Xml2Array::toArray($response);
                $commonResponse = $data['S:Body']['ns2:' . $command . 'Response'][$command . 'Result']['commonResponse'];
                $success        = $commonResponse['resultCode'] === "True";

                if (!$success) {
                    if (isset($commonResponse['errorInfos']['errorMsg'])) {
                        $message[] = $commonResponse['errorInfos']['errorMsg'];
                        \Log::info("Meet TLL Error Code {$commonResponse['errorInfos']['errorCode']}");
                        $data["errorCode"] = $commonResponse['errorInfos']['errorCode'];
                    } else {
                        foreach ($commonResponse['errorInfos'] as $error) {
                            $message[] = $error['errorMsg'];
                        }
                    }
                } else {
                    // handle response data
                    if (isset($data['S:Body']['ns2:' . $command . 'Response'][$command . 'Result']['extendLincoln'])) {
                        $data = $data['S:Body']['ns2:' . $command . 'Response'][$command . 'Result']['extendLincoln'];
                    }
                }
            } else {
                $success = false;
            }
            $soapApiLog['response']   = $response;
            $soapApiLog['is_success'] = $success;
            if ($isWriteLog) {
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success'     => $success,
                'message'     => $success ? [] : $message,
                'data'        => $data,
                'xmlResponse' => $response
            ]);
        } catch (\Exception $e) {
            $soapApiLog['response']   = $e->getMessage();
            $soapApiLog['is_success'] = false;
            if ($isWriteLog) {
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success'     => false,
                'message'     => $e->getMessage(),
                'xmlResponse' => $response
            ]);
        }
    }

    /**
     * @param array $dateValidation
     * @param Request $request
     * @return void
     */
    public function setEmptyRoomSoapRequest(array $dateValidation, Request $request, $command): void
    {
        $startDay       = $dateValidation['startDay'];
        $endDay         = $dateValidation['endDay'];
        $perRmPaxCount  = $request->input('person_number');
        $tllHotelCode   = $request->input('tllHotelCode');
        $tllRmTypeCode  = $request->input('tllRmTypeCode');
        $tllRmTypeInfos = [];

        if (!is_array($tllRmTypeCode)) {
            $tllRmTypeInfos['tllRmTypeCode'] = $tllRmTypeCode;
        } else {
            foreach ($tllRmTypeCode as $item) {
                $tllRmTypeInfos[] = ['tllRmTypeCode' => $item];
            }
        }

        $dataRequest = [
            'extractionRequest' => [
                'startDay'      => $startDay,
                'endDay'        => $endDay,
                'perRmPaxCount' => $perRmPaxCount,
            ],
            'hotelInfos'        => [
                'tllHotelCode'   => $tllHotelCode,
                'tllRmTypeInfos' => $tllRmTypeInfos
            ]
        ];

        $this->setSoapRequest($dataRequest, $command);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function setBulkEmptyRoomSoapRequest(Request $request, $command): void
    {
        $tllHotelCode   = $request->input('tllHotelCode');
        $tllRmTypeCode  = $request->input('tllRmTypeCode');
        $tllRmTypeInfos = [];

        if (!is_array($tllRmTypeCode)) {
            $tllRmTypeInfos['tllRmTypeCode'] = $tllRmTypeCode;
        } else {
            foreach ($tllRmTypeCode as $item) {
                $tllRmTypeInfos[] = ['tllRmTypeCode' => $item];
            }
        }

        $dataRequest = [
            'hotelInfos' => [
                'tllHotelCode'   => $tllHotelCode,
                'tllRmTypeInfos' => $tllRmTypeInfos
            ]
        ];

        $this->setSoapRequest($dataRequest, $command);
    }

    /**
     * @param array $dateValidation
     * @param Request $request
     * @return void
     */
    public function setPricePlanSoapRequest(array $dateValidation, Request $request, $command): void
    {
        $startDay      = $dateValidation['startDay'];
        $endDay        = $dateValidation['endDay'];
        $minPrice      = $request->input('min_price');
        $maxPrice      = $request->input('max_price');
        $perPaxCount   = $request->input('person_number');
        $tllHotelCode  = $request->input('tllHotelCode');
        $tllRmTypeCode = $request->input('tllRmTypeCode');
        $tllPlanCode   = $request->input('tllPlanCode');
        $tllPlanInfos  = [];
        if (!is_array($tllPlanCode)) {
            $tllPlanInfos['tllPlanCode'] = $tllPlanCode;
        } else {
            foreach ($tllPlanCode as $item) {
                $tllPlanInfos[] = ['tllPlanCode' => $item];
            }
        }
        if (!is_array($tllRmTypeCode)) {
            $tllPlanInfos['tllRmTypeCode'] = $tllRmTypeCode;
        } else {
            foreach ($tllRmTypeCode as $item) {
                $tllPlanInfos[] = ['tllRmTypeCode' => $item];
            }
        }

        $dataRequest = [
            'extractionRequest' => [
                'startDay'    => $startDay,
                'endDay'      => $endDay,
                'minPrice'    => $minPrice,
                'maxPrice'    => $maxPrice,
                'perPaxCount' => $perPaxCount
            ],
            'hotelInfos'        => [
                'tllHotelCode' => $tllHotelCode,
                'tllPlanInfos' => $tllPlanInfos
            ]
        ];

        $this->setSoapRequest($dataRequest, $command);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function setBulkPricePlanSoapRequest(Request $request, $command): void
    {
        $tllHotelCode  = $request->input('tllHotelCode');
        $tllRmTypeCode = $request->input('tllRmTypeCode');
        $tllPlanCode   = $request->input('tllPlanCode');

        $tllRmTypeInfos = [];
        if (!is_array($tllRmTypeCode)) {
            $tllRmTypeInfos['tllRmTypeCode'] = $tllRmTypeCode;
            $tllRmTypeInfos['tllPlanCode']   = $tllPlanCode;
        } else {
            foreach ($tllRmTypeCode as $item) {
                $tllRmTypeInfos[] = ['tllRmTypeCode' => $item, 'tllPlanCode' => $tllPlanCode];
            }
        }

        $dataRequest = [
            'hotelInfos' => [
                'tllHotelCode' => $tllHotelCode,
                'tllPlanInfos' => $tllRmTypeInfos
            ]
        ];

        $this->setSoapRequest($dataRequest, $command);
    }

    /**
     * search room type
     * @param Request $request
     * @return void
     */
    public function searchRoomType($request)
    {
        $isWriteLog = config('sc.is_write_log');
        $command    = 'readRmType';
        // set header request
        $this->tlLincolnSoapClient->setHeaders();
        // set body request
        $dataRequest = $this->formatSoapArrayBody->getArrayRoomTypeAndPlanBody($request);
        $naifVersion = config('sc.tllincoln_api.xml.xmlns_type') . '_6000';
        $this->setSoapRequest($dataRequest, $command, $naifVersion);

        try {
            $url        = config('sc.tllincoln_api.search_room_type');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $this->tlLincolnSoapClient->getBody(),
            ];
            $response   = $this->tlLincolnSoapClient->callSoapApi($url);
            $data       = [];
            $success    = true;

            if ($response !== null) {
                $arrRooms = $this->tlLincolnSoapClient->convertResponeToArray($response);
                if (isset($arrRooms['ns2:' . $command .'Response'][ $command .'Result']['timeInfo'])) {
                    $data['timeInfo'] = $arrRooms['ns2:' . $command .'Response'][ $command .'Result']['timeInfo'];
                }
                if (isset($arrRooms['ns2:' . $command .'Response'][ $command .'Result']['hotelInfos'])) {
                    $data['hotelInfos'] = $arrRooms['ns2:' . $command .'Response'][ $command .'Result']['hotelInfos'];
                }
            } else {
                $success = false;
            }

            if ($isWriteLog) {
                $soapApiLog['response']   = $response;
                $soapApiLog['is_success'] = $success;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success'     => $success,
                'data'        => $data,
                'xmlResponse' => $response
            ]);
        } catch (\Exception $e) {
            if ($isWriteLog) {
                $soapApiLog['response']   = $e->getMessage();
                $soapApiLog['is_success'] = false;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * search plan
     * @param Request $request
     * @return void
     */
    public function searchPlan($request)
    {
        $isWriteLog = config('sc.is_write_log');
        $command    = 'readPlan';
        // set header request
        $this->tlLincolnSoapClient->setHeaders();
        // set body request
        $dataRequest = $this->formatSoapArrayBody->getArrayRoomTypeAndPlanBody($request);
        $naifVersion = config('sc.tllincoln_api.xml.xmlns_type') . '_6000';
        $this->setSoapRequest($dataRequest, $command, $naifVersion);

        try {
            $url        = config('sc.tllincoln_api.search_plan');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $this->tlLincolnSoapClient->getBody(),
            ];
            $response   = $this->tlLincolnSoapClient->callSoapApi($url);
            $data       = [];
            $success    = true;

            if ($response !== null) {
                $arrRooms = $this->tlLincolnSoapClient->convertResponeToArray($response);
                if (isset($arrRooms['ns2:' . $command .'Response'][ $command .'Result']['timeInfo'])) {
                    $data['timeInfo'] = $arrRooms['ns2:' . $command .'Response'][ $command .'Result']['timeInfo'];
                }
                if (isset($arrRooms['ns2:' . $command .'Response'][ $command .'Result']['hotelInfos'])) {
                    $data['hotelInfos'] = $arrRooms['ns2:' . $command .'Response'][ $command .'Result']['hotelInfos'];
                }
            } else {
                $success = false;
            }

            if ($isWriteLog) {
                $soapApiLog['response']   = $response;
                $soapApiLog['is_success'] = $success;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success'     => $success,
                'data'        => $data,
                'xmlResponse' => $response
            ]);
        } catch (\Exception $e) {
            if ($isWriteLog) {
                $soapApiLog['response']   = $e->getMessage();
                $soapApiLog['is_success'] = false;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * read option
     * @param Request $request
     * @return void
     */
    public function searchReadOption($request)
    {
        $isWriteLog = config('sc.is_write_log');
        $command    = 'readOption';
        // set header request
        $this->tlLincolnSoapClient->setHeaders();
        // set body request
        $dataRequest = $this->formatSoapArrayBody->getArrayReadOptionBody($request);
        $naifVersion = config('sc.tllincoln_api.xml.xmlns_type') . '_6000';
        $this->setSoapRequest($dataRequest, $command, $naifVersion);

        try {
            $url        = config('sc.tllincoln_api.search_read_option');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $this->tlLincolnSoapClient->getBody(),
            ];
            $response   = $this->tlLincolnSoapClient->callSoapApi($url);
            $data       = [];
            $success    = true;

            if ($response !== null) {
                $arrRooms = $this->tlLincolnSoapClient->convertResponeToArray($response);
                if (isset($arrRooms['ns2:' . $command .'Response'][ $command .'Result']['hotelInfos'])) {
                    $data['hotelInfos'] = $arrRooms['ns2:' . $command .'Response'][ $command .'Result']['hotelInfos'];
                }
            } else {
                $success = false;
            }

            if ($isWriteLog) {
                $soapApiLog['response']   = $response;
                $soapApiLog['is_success'] = $success;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success'     => $success,
                'data'        => $data,
                'xmlResponse' => $response
            ]);
        } catch (\Exception $e) {
            if ($isWriteLog) {
                $soapApiLog['response']   = $e->getMessage();
                $soapApiLog['is_success'] = false;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function searchHotelAvail(Request $request)
    {
        $file = 'hotelAvail.xsd';
        $command = 'hotelAvail';
        $this->getHotelSearchOTA($request, $command, $file);
    }

    public function searchHotel(Request $request)
    {
        $file = 'searchHotel.xsd';
        $command = 'searchHotel';
        $this->getHotelSearchOTA($request, $command, $file);
    }

    /**
     * hotel avail
     * @param Request $request
     * @return void
     */
    public function getHotelSearchOTA(Request $request, $command, $file)
    {
        $isWriteLog = config('sc.is_write_log');
        $command    = 'hotelAvail';

        $xsdPath = storage_path(config('sc.xsd_path') . $file);

        try {
            $xml = new \DOMDocument();
            $xml->loadXML($request->getContent());

            $xml->schemaValidate($xsdPath);

            $url        = config('sc.tllincoln_api.hotel_avail');
            $soapApiLog = [
                'data_id' => ScTlLincolnSoapApiLog::genDataId(),
                'url'     => $url,
                'command' => $command,
                "request" => $request,
            ];
            $response   = $this->tlLincolnSoapClient->callSoapApi($url);
            $data       = [];
            $success    = true;

            if ($response !== null) {
                $data = $this->tlLincolnSoapClient->convertResponeToArray($response);
            } else {
                $success = false;
            }

            if ($isWriteLog) {
                $soapApiLog['response']   = $response;
                $soapApiLog['is_success'] = $success;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success'     => $success,
                'data'        => $data,
                'xmlResponse' => $response
            ]);
        } catch (\Exception $e) {
            if ($isWriteLog) {
                $soapApiLog['response']   = $e->getMessage();
                $soapApiLog['is_success'] = false;
                ScTlLincolnSoapApiLog::createLog($soapApiLog);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $dataRequest
     * @param $setMainBodyWrapSection
     * @return void
     */
    public function setSoapRequest($dataRequest, $setMainBodyWrapSection, $versionNaif = null)
    {
        //set header request
        $this->tlLincolnSoapClient->setHeaders();
        //set param common request
        $this->tlLincolnSoapBody->setMainBodyWrapSection($setMainBodyWrapSection . 'Request');
        $tllincolnAccount = TllincolnAccount::first();
        $userInfo         = [
            'agtId'       => $tllincolnAccount->agt_id,
            'agtPassword' => $tllincolnAccount->agt_password
        ];
        if ($versionNaif == null) {
            $versionNaif = config('sc.tllincoln_api.xml.xmlns_type') . '_common';
        }
        $xmlnsType        = config('sc.tllincoln_api.xml.xmlns_type');
        $xmlnsVersionKey  = "sc.tllincoln_api.xml.$xmlnsType.$versionNaif";
        $xmlnsVersion     = config($xmlnsVersionKey);
        $body             = $this->tlLincolnSoapBody->generateBody(
            $setMainBodyWrapSection,
            $dataRequest,
            $xmlnsType,
            $xmlnsVersion,
            $userInfo
        );
        //set body request
        $this->tlLincolnSoapClient->setBody($body);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    private function validateAndParseDates(Request $request)
    {
        $dateFormat = config('sc.tllincoln_api.tllincoln_date_format_api');
        $dateFrom   = $request->input('date_from');
        $dateTo     = $request->input('date_to');
        try {
            $startDay  = $dateFrom ? Carbon::parse($dateFrom)->format($dateFormat) : Carbon::now()->format($dateFormat);
            $endDay    = $dateTo ? Carbon::parse($dateTo)->format($dateFormat) : Carbon::parse($startDay)->addDay(
                config('sc.tllincoln_api.get_empty_room_max_day')
            )->format($dateFormat);
            $endDayMax = Carbon::parse($startDay)->addDays(30)->format($dateFormat);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'date input is not valid!'
            ];
        }

        $validator = \Validator::make($request->all(), [
            'date_from' => ['nullable', 'date', 'date_format:' . $dateFormat],
            'date_to'   => [
                'nullable',
                'date',
                'date_format:' . $dateFormat,
                'after_or_equal:date_from',
                'before_or_equal:' . $endDayMax
            ]
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()
            ];
        }

        return compact('startDay', 'endDay');
    }
}
