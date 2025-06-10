<?php

namespace ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln;

/**
 *
 */
class FormatSoapArrayBody
{
    //API 共通室タイプマスタ / 共通プランマスタ
    /**
     * search room type
     * @param array $request
     * @return array
     */
    public function getArrayRoomTypeAndPlanBody(array $request)
    {
        $dataRequest = [
            'langInfo' => [
                'PrimaryLangID' => $request['PrimaryLangID'] ?? config('sc.default_language'),
            ],
            'hotelInfos' => $request['hotelInfos'] ?? '',
            'timeInfo' => [
                'searchTimeFrom' => $request['searchTimeFrom'] ?? '',
            ]
        ];
        return $dataRequest;
    }

    //API 共通オプションマスタ
    public function getArrayReadOptionBody($request)
    {
        $dataRequest = [
            'langInfo' => [
                'PrimaryLangID' => $request['PrimaryLangID'] ?? config('sc.default_language'),
            ],
            'hotelInfos' => $request['hotelInfos'] ?? '',
        ];
        return $dataRequest;
    }

    //API 共通オプションマスタ
    public function getArrayEntryBookingBody($request)
    {
        $dataRequest = [
            'extendLincoln' => [
                'tllHotelCode' => $request['tllHotelCode'] ?? '',
                'useTllPlan' => $request['useTllPlan'] ?? '',
                'tllBookingNumber' => $request['tllBookingNumber'] ?? '',
                'tllCharge' => $request['tllCharge'] ?? '',
            ],
            'SendInformation' => [
                'assignDiv' => $request['assignDiv'] ?? '',
                'genderDiv' => $request['genderDiv'] ?? '',
            ],
            'AllotmentBookingReport' => [
                'TransactionType' => [
                    'DataFrom' => $request['DataFrom'] ?? '',
                    'DataClassification' => $request['DataClassification'] ?? '',
                    'DataID' => $request['DataID'] ?? '',
                ],
                'AccommodationInformation' => [
                    'AccommodationArea' => $request['AccommodationArea'] ?? '',
                    'AccommodationName' => $request['AccommodationName'] ?? '',
                    'AccommodationCode' => $request['AccommodationCode'] ?? '',
                    'ChainName' => $request['ChainName'] ?? '',
                ],
                'SalesOfficeInformation' => [
                    'SalesOfficeCompanyName' => $request['SalesOfficeCompanyName'] ?? '',
                    'SalesOfficeName' => $request['SalesOfficeName'] ?? '',
                    'SalesOfficeCode' => $request['SalesOfficeCode'] ?? '',
                    'SalesOfficePersonInCharge' => $request['SalesOfficePersonInCharge'] ?? '',
                    'SalesOfficeEmail' => $request['SalesOfficeEmail'] ?? '',
                    'SalesOfficePhoneNumber' => $request['SalesOfficePhoneNumber'] ?? '',
                    'SalesOfficeFaxNumber' => $request['SalesOfficeFaxNumber'] ?? '',
                ],
                'BasicInformation' => [
                    'TravelAgencyBookingNumber' => $request['TravelAgencyBookingNumber'] ?? '',
                    'TravelAgencyBookingDate' => $request['TravelAgencyBookingDate'] ?? '',
                    'TravelAgencyBookingTime' => $request['TravelAgencyBookingTime'] ?? '',
                    'GuestOrGroupNameSingleByte' => $request['GuestOrGroupNameSingleByte'] ?? '',
                    'GuestOrGroupNameDoubleByte' => $request['GuestOrGroupNameDoubleByte'] ?? '',
                    'GuestOrGroupKanjiName' => $request['GuestOrGroupKanjiName'] ?? '',
                    'GuestOrGroupContactDiv' => $request['GuestOrGroupContactDiv'] ?? '',
                    'GuestOrGroupCellularNumber' => $request['GuestOrGroupCellularNumber'] ?? '',
                    'GuestOrGroupOfficeNumber' => $request['GuestOrGroupOfficeNumber'] ?? '',
                    'GuestOrGroupPhoneNumber' => $request['GuestOrGroupPhoneNumber'] ?? '',
                    'GuestOrGroupEmail' => $request['GuestOrGroupEmail'] ?? '',
                    'GuestOrGroupPostalCode' => $request['GuestOrGroupPostalCode'] ?? '',
                    'GuestOrGroupAddress' => $request['GuestOrGroupAddress'] ?? '',
                    'GroupNameWelcomeBoard' => $request['GroupNameWelcomeBoard'] ?? '',
                    'GuestGenderDiv' => $request['GuestGenderDiv'] ?? '',
                    'GuestGeneration' => $request['GuestGeneration'] ?? '',
                    'GuestAge' => $request['GuestAge'] ?? '',
                    'CheckInDate' => $request['CheckInDate'] ?? '',
                    'CheckInTime' => $request['CheckInTime'] ?? '',
                    'CheckOutDate' => $request['CheckOutDate'] ?? '',
                    'CheckOutTime' => $request['CheckOutTime'] ?? '',
                    'Nights' => $request['Nights'] ?? '',
                    'Transportaion' => $request['Transportaion'] ?? '',
                    'TotalRoomCount' => $request['TotalRoomCount'] ?? '',
                    'GrandTotalPaxCount' => $request['GrandTotalPaxCount'] ?? '',
                    'TotalPaxMaleCount' => $request['TotalPaxMaleCount'] ?? '',
                    'TotalPaxFemaleCount' => $request['TotalPaxFemaleCount'] ?? '',
                    'TotalChildA70Count' => $request['TotalChildA70Count'] ?? '',
                    'TotalChildA70Count2' => $request['TotalChildA70Count2'] ?? '',
                    'TotalChildB50Count' => $request['TotalChildB50Count'] ?? '',
                    'TotalChildB50Count2' => $request['TotalChildB50Count2'] ?? '',
                    'TotalChildC30Count' => $request['TotalChildC30Count'] ?? '',
                    'TotalChildDNoneCount' => $request['TotalChildDNoneCount'] ?? '',
                    'TypeOfGroupDoubleByte' => $request['TypeOfGroupDoubleByte'] ?? '',
                    'PackageType' => $request['PackageType'] ?? '',
                    'PackagePlanName' => $request['PackagePlanName'] ?? '',
                    'PackagePlanCode' => $request['PackagePlanCode'] ?? '',
                    'PackagePlanContent' => $request['PackagePlanContent'] ?? '',
                    'MealCondition' => $request['MealCondition'] ?? '',
                    'SpecificMealCondition' => $request['SpecificMealCondition'] ?? '',
                    'ModificationPoint' => $request['ModificationPoint'] ?? '',
                    'SpecialServiceRequest' => $request['SpecialServiceRequest'] ?? '',
                    'OtherServiceInformation' => $request['OtherServiceInformation'] ?? '',
                    'SalesOfficeComment' => $request['SalesOfficeComment'] ?? '',
                    'QuestionAndAnswerList' => $request['QuestionAndAnswerList'] ?? [],
                ],
                'BasicRateInformation' => [
                    'RoomRateOrPersonalRate' => $request['RoomRateOrPersonalRate'] ?? '',
                    'TaxServiceFee' => $request['TaxServiceFee'] ?? '',
                    'Payment' => $request['Payment'] ?? '',
                    'SettlementDiv' => $request['SettlementDiv'] ?? '',
                    'TotalAccommodationCharge' => $request['TotalAccommodationCharge'] ?? '',
                    'TotalAccommodationConsumptionTax' => $request['TotalAccommodationConsumptionTax'] ?? '',
                    'TotalAccommodationHotSpringTax' => $request['TotalAccommodationHotSpringTax'] ?? '',
                    'TotalAccomodationServiceCharge' => $request['TotalAccomodationServiceCharge'] ?? '',
                    'TotalAccommodationDiscountPoints' => $request['TotalAccommodationDiscountPoints'] ?? '',
                    'TotalAccommodationConsumptionTaxAfterDiscountPoints' => $request['TotalAccommodationConsumptionTaxAfterDiscountPoints'] ?? '',
                    'AmountClaimed' => $request['AmountClaimed'] ?? '',
                    'PointsDiscountList' => $request['PointsDiscountList'] ?? [],
                    'DepositList' => $request['DepositList'] ?? [],
                ],
                'MemberInformation' => [
                    'MemberName' => $request['MemberName'] ?? '',
                    'MemberKanjiName' => $request['MemberKanjiName'] ?? '',
                    'MemberMiddleName' => $request['MemberMiddleName'] ?? '',
                    'MemberDateOfBirth' => $request['MemberDateOfBirth'] ?? '',
                    'MemberEmergencyNumber' => $request['MemberEmergencyNumber'] ?? '',
                    'MemberOccupation' => $request['MemberOccupation'] ?? '',
                    'MemberOrganization' => $request['MemberOrganization'] ?? '',
                    'MemberOrganizationKana' => $request['MemberOrganizationKana'] ?? '',
                    'MemberOrganizationCode' => $request['MemberOrganizationCode'] ?? '',
                    'MemberPosition' => $request['MemberPosition'] ?? '',
                    'MemberOfficePostalCode' => $request['MemberOfficePostalCode'] ?? '',
                    'MemberOfficeAddress' => $request['MemberOfficeAddress'] ?? '',
                    'MemberOfficeTelephoneNumber' => $request['MemberOfficeTelephoneNumber'] ?? '',
                    'MemberOfficeFaxNumber' => $request['MemberOfficeFaxNumber'] ?? '',
                    'MemberGenderDiv' => $request['MemberGenderDiv'] ?? '',
                    'MemberClass' => $request['MemberClass'] ?? '',
                    'CurrentPoints' => $request['CurrentPoints'] ?? '',
                    'MailDemandDiv' => $request['MailDemandDiv'] ?? '',
                    'PamphletDemandDiv' => $request['PamphletDemandDiv'] ?? '',
                    'MemberID' => $request['MemberID'] ?? '',
                    'MemberPhoneNumber' => $request['MemberPhoneNumber'] ?? '',
                    'MemberEmail' => $request['MemberEmail'] ?? '',
                    'MemberPostalCode' => $request['MemberPostalCode'] ?? '',
                    'MemberAddress' => $request['MemberAddress'] ?? '',
                ],
                'OptionInformation' => [
                    'OptionList' => $request['OptionList'] ?? [],
                ],
                'RoomInformationList' => [
                    'RoomAndGuestList' => [
                        'RoomAndGuest' => $request['RoomAndGuest'],
                    ],
                ],
            ],
        ];
        return $dataRequest;
    }

    //API cancel booking
    public function getArrayCancelBookingBody($request)
    {
        $dataRequest = [
            'bookingInfo' => [
                'tllHotelCode' => $request['tllHotelCode'] ?? '',
                'tllBookingNumber' => $request['tllBookingNumber'] ?? '',
                'DataID' => $request['DataID'] ?? '',
                'CancellationCharge' => $request['CancellationCharge'] ?? '',
                'CancellationNotice' => $request['CancellationNotice'] ?? '',
            ],
        ];
        return $dataRequest;
    }
}
