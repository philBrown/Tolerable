<?php

namespace Tolerable\AusPost;

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
    
    
    public function calculateDomesticParcelPostage($fromPostcode, $toPostcode, $length, $width, $height, $weight, $serviceCode, $optionCode = null, $subOptionCode = null, $extraCover = null)
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
        return $this->request(self::API_BASE_URL . self::DOMESTIC_PARCEL_POSTAGE, $params);
    }
    
    public function calculateInternationalParcelPostage($countryCode, $weight, $serviceCode, $optionCode = null, $extraCover = null)
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
        return $this->request(self::API_BASE_URL . self::INTERNATIONAL_PARCEL_POSTAGE, $params);
    }
    
    public function listCountries()
    {
        return $this->request(self::API_BASE_URL . self::COUNTRY);
    }
    
    public function listDomesticParcelServices()
    {
        return $this->request(self::API_BASE_URL . self::DOMESTIC_PARCEL_SERVICE_LIST);
    }
    
    public function listInternationalParcelServices()
    {
        return $this->request(self::API_BASE_URL . self::INTERNATIONAL_PARCEL_SERVICE_LIST);
    }
}
