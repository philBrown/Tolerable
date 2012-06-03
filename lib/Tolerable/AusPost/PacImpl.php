<?php
namespace Tolerable\AusPost;

use Tolerable\AusPost\Response\ListCountriesResponse;
use Tolerable\AusPost\Response\ListParcelServicesResponse;
use Tolerable\AusPost\Response\PostageResultResponse;
use Tolerable\AusPost\Service\ParcelService;
use Tolerable\AusPost\Service\ParcelServiceOption;
use Tolerable\AusPost\Service\ParcelServiceSubOption;
use Tolerable\AusPost\Postage\Cost;

use Guzzle\Service\ClientInterface;

class PacImpl extends Api implements Pac
{
    const API_BASE_URL = 'https://auspost.com.au/api/postage/';
    
    const COUNTRY = 'country';
    
    const DOMESTIC_LETTER_SERVICE_LIST = 'letter/domestic/service';
    const DOMESTIC_PARCEL_SERVICE_LIST = 'parcel/domestic/service';
    const INTERNATIONAL_LETTER_SERVICE_LIST = 'letter/international/service';
    const INTERNATIONAL_PARCEL_SERVICE_LIST = 'parcel/international/service';
    
    const DOMESTIC_LETTER_POSTAGE = 'letter/domestic/calculate';
    const DOMESTIC_PARCEL_POSTAGE = 'parcel/domestic/calculate';
    const INTERNATIONAL_LETTER_POSTAGE = 'letter/international/calculate';
    const INTERNATIONAL_PARCEL_POSTAGE = 'parcel/international/calculate';
    
    /** Dimension parameter constants */
    const LENGTH    = 'length';
    const WIDTH     = 'width';
    const HEIGHT    = 'height';
    const THICKNESS = 'thickness';
    const WEIGHT    = 'weight';
    
    const FROM_POSTCODE = 'from_postcode';
    const TO_POSTCODE   = 'to_postcode';
    
    const COUNTRY_CODE = 'country_code';
    
    const SERVICE_CODE   = 'service_code';
    const OPTION_CODE    = 'option_code';
    const SUBOPTION_CODE = 'suboption_code';
    const EXTRA_COVER    = 'extra_cover';
    
    private $serviceWhitelist;
    private $optionWhitelist;
    private $subOptionWhitelist;
    
    public function __construct(ClientInterface $client, $key,
            $serviceWhitelist = null, $optionWhitelist = null,
            $subOptionWhitelist = null) {
        parent::__construct($client, $key);
        
        $this->serviceWhitelist = $serviceWhitelist;
        $this->optionWhitelist = $optionWhitelist;
        $this->subOptionWhitelist = $subOptionWhitelist;
    }
    
    /**
     * @return PostageResultResponse 
     */
    public function calculateDomesticParcelPostage($fromPostcode, $toPostcode, $length, $width, $height, $weight, $serviceCode, $optionCode = null, array $subOptionCode = array(), $extraCover = null)
    {
        $params = array(
            self::FROM_POSTCODE => $fromPostcode,
            self::TO_POSTCODE   => $toPostcode,
            self::LENGTH        => $length,
            self::WIDTH         => $width,
            self::HEIGHT        => $height,
            self::WEIGHT        => $weight,
            self::SERVICE_CODE  => $serviceCode
        );
        if (null !== $optionCode) {
            $params[self::OPTION_CODE] = $optionCode;
        }
        if (null !== $subOptionCode) {
            $params[self::SUBOPTION_CODE] = $subOptionCode;
        }
        if (null !== $extraCover) {
            $params[self::EXTRA_COVER] = $extraCover;
        }
        $response = $this->request(self::API_BASE_URL . self::DOMESTIC_PARCEL_POSTAGE, $params);
        return $this->postageResultFactory($response);
    }
    
    public function calculateInternationalParcelPostage($countryCode, $weight, $serviceCode, array $optionCode = array(), $extraCover = null)
    {
        $params = array(
            self::COUNTRY_CODE => $countryCode,
            self::WEIGHT       => $weight,
            self::SERVICE_CODE => $serviceCode,
        );
        if (null !== $optionCode) {
            $params[self::OPTION_CODE] = $optionCode;
        }
        if (null !== $extraCover) {
            $params[self::EXTRA_COVER] = $extraCover;
        }
        $response = $this->request(self::API_BASE_URL . self::INTERNATIONAL_PARCEL_POSTAGE, $params);
        return $this->postageResultFactory($response);
    }
    
    /**
     * @return ListCountriesResponse
     */
    public function listCountries()
    {
        $response = $this->request(self::API_BASE_URL . self::COUNTRY);
        $list = new ListCountriesResponse();
        foreach ($response->countries->country as $country) {
            $list->addCountry(new Country($country->code, $country->name));
        }
        return $list;
    }
    
    public function listDomesticParcelServices($fromPostcode, $toPostcode, $length, $width, $height, $weight)
    {
        $params = array(
            self::FROM_POSTCODE => $fromPostcode,
            self::TO_POSTCODE   => $toPostcode,
            self::LENGTH        => $length,
            self::WIDTH         => $width,
            self::HEIGHT        => $height,
            self::WEIGHT        => $weight
        );
        
        $response = $this->request(self::API_BASE_URL . self::DOMESTIC_PARCEL_SERVICE_LIST, $params);
        
        return $this->parcelServiceFactory($response);
    }
    
    public function listInternationalParcelServices($countryCode, $weight)
    {
        $params = array(
            self::COUNTRY_CODE => $countryCode,
            self::WEIGHT       => $weight
        );
        
        $response = $this->request(self::API_BASE_URL . self::INTERNATIONAL_PARCEL_SERVICE_LIST, $params);
        
        return $this->parcelServiceFactory($response);
    }
    
    /**
     * @param stdclass $response
     * @return ListParcelServicesResponse
     */
    private function parcelServiceFactory($response) {
        $list = new ListParcelServicesResponse;
        
        /*
         * Remember to check each collection is actually an array.
         * AusPost seems to think it's ok to return an object for single
         * result collections
         */
        $services = $response->services->service;
        if (!is_array($services)) {
            $services = array($services);
        }
        foreach ($services as $svc) {
            if (is_array($this->serviceWhitelist) && !in_array($svc->code, $this->serviceWhitelist)) {
                continue;
            }
            $service = new ParcelService($svc->code, $svc->name);
            if (isset($svc->price)) {
                $service->setPrice($svc->price);
            }
            if (isset($svc->max_extra_cover)) {
                $service->setMaxExtraCover($svc->max_extra_cover);
            }
            if (!empty($svc->options)) {
                $options = $svc->options->option;
                if (!is_array($options)) {
                    $options = array($options);
                }
                foreach ($options as $opt) {
                    if (is_array($this->optionWhitelist) && !in_array($opt->code, $this->optionWhitelist)) {
                        continue;
                    }
                    $option = new ParcelServiceOption($opt->code, $opt->name);
                    if (!empty($opt->suboptions)) {
                        $suboptions = $opt->suboptions->option;
                        if (!is_array($suboptions)) {
                            $suboptions = array($suboptions);
                        }
                        foreach ($suboptions as $subopt) {
                            if (is_array($this->subOptionWhitelist) && !in_array($subopt->code, $this->subOptionWhitelist)) {
                                continue;
                            }
                            $option->addSubOption(new ParcelServiceSubOption($subopt->code, $subopt->name));
                        }
                    }
                    $service->addOption($option);
                }
            }
            $list->addService($service);
        }
        return $list;        
    }
    
    /**
     * @param stdclass $response 
     * @return PostageResultResponse
     */
    private function postageResultFactory($response) {
        $res = $response->postage_result;
        $result = new PostageResultResponse($res->service, $res->total_cost);
        
        if (isset($res->delivery_time)) {
            $result->setDeliveryTime($res->delivery_time);
        }
        
        if (isset($res->costs)) {
            $costs = $res->costs->cost;
            if (!is_array($costs)) {
                $costs = array($costs);
            }
            foreach ($costs as $cost) {
                $result->addCost(new Cost($cost->cost, $cost->item));
            }
        }
        
        return $result;
    }
}
