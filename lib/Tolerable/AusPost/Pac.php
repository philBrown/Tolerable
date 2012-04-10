<?php
namespace Tolerable\AusPost;

use Tolerable\AusPost\Response\ListCountriesResponse;
use Tolerable\AusPost\Response\ListParcelServicesResponse;

interface Pac
{
    /**
     * @return ListCountriesResponse
     */
    public function listCountries();
    
    /**
     * @return ListParcelServicesResponse
     */
    public function listDomesticParcelServices($fromPostcode, $toPostcode, $length, $width, $height, $weight);
    
    /**
     * @return object
     */
    public function listInternationalParcelServices($countryCode, $weight);
    
    /**
     * @param string $fromPostcode
     * @param string $toPostcode
     * @param int    $length        In cm
     * @param int    $width         In cm
     * @param int    $height        In cm
     * @param int    $weight        In kg
     * @param string $serviceCode
     * @param string $optionCode
     * @param string $subOptionCode
     * @param int $extraCover       In dollars
     * @return object
     */
    public function calculateDomesticParcelPostage($fromPostcode, $toPostcode,
            $length, $width, $height, $weight, $serviceCode,
            $optionCode = null, $subOptionCode = null, $extraCover = null);
    
    /**
     * @param string $countryCode
     * @param int    $weight      In cm
     * @param string $serviceCode
     * @param string $optionCode
     * @param int    $extraCover  In dollars
     * @return object
     */
    public function calculateInternationalParcelPostage($countryCode, $weight,
            $serviceCode, $optionCode = null, $extraCover = null);
}
