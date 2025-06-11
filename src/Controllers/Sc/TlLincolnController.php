<?php

namespace ThachVd\LaravelSiteControllerApi\Controllers\Sc;

use App\Http\Controllers\Controller;
use ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln\TlLincolnSoapBody;
use ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln\TlLincolnSoapClient;
use ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln\TlLincolnSoapService;
use Illuminate\Http\Request;

/**
 *
 */
class TlLincolnController extends Controller
{
    /**
     * @var TlLincolnSoapService
     */
    protected $tlLincolnService;

    /**
     * @param TlLincolnSoapClient $tLLincolnSoapClient
     * @param TlLincolnSoapBody $tlLincolnSoapBody
     */
    public function __construct()
    {
        $serviceClass           = config('sc.tllincoln.booking_handler'); // Lấy class từ config
        $this->tlLincolnService = app($serviceClass);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getRoomType(Request $request)
    {
        return $this->tlLincolnService->getRoomType($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPlan(Request $request)
    {
        return $this->tlLincolnService->getPlan($request);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|void
     */
    public function getEmptyRoom(Request $request)
    {
        // example request
        // tllHotelCode: C77338
        // tllRmTypeCode: 482
        // date_from: 20250111
        // date_to: 20250112
        // person_number: 1
        return $this->tlLincolnService->getEmptyRoom($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBulkEmptyRoom(Request $request)
    {
        // example request
        // tllHotelCode: C77338
        // tllRmTypeCode: 482
        return $this->tlLincolnService->getBulkEmptyRoom($request);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getPricePlan(Request $request)
    {
        // example request
        // tllHotelCode: C77338
        // tllPlanCode: 15303611
        // tllRmTypeCode: 482
        // person_number: 1
        // date_from: 20250117
        // date_to: 20250118
        return $this->tlLincolnService->getPricePlan($request);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBulkPricePlan(Request $request)
    {
        // example request
        // tllHotelCode: C77338
        // tllPlanCode: 15303611
        // tllRmTypeCode: 482
        return $this->tlLincolnService->getBulkPricePlan($request);
    }

    /**
     * @param Request $request
     */
    public function createBooking(Request $request)
    {
        $this->tlLincolnService->createBooking($request);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function cancelBooking(Request $request)
    {
        //TODO implement cancelBooking
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getOption(Request $request)
    {
        return $this->tlLincolnService->getOption($request);
    }
}
