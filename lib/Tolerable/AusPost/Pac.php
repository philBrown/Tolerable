<?php
namespace Tolerable\AusPost;

use Tolerable\AusPost\Response\ListCountriesResponse;
use Tolerable\AusPost\Response\ListParcelServicesResponse;
use Tolerable\AusPost\Response\PostageResultResponse;

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
     * @return ListParcelServicesResponse
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
     * @param array  $subOptionCode
     * @param int $extraCover       In dollars
     * @return PostageResultResponse
     */
    public function calculateDomesticParcelPostage($fromPostcode, $toPostcode,
            $length, $width, $height, $weight, $serviceCode,
            $optionCode = null, array $subOptionCode = array(), $extraCover = null);
    
    /**
     * @param string $countryCode
     * @param int    $weight      In cm
     * @param string $serviceCode
     * @param array  $optionCode
     * @param int    $extraCover  In dollars
     * @return PostageResultResponse
     */
    public function calculateInternationalParcelPostage($countryCode, $weight,
            $serviceCode, array $optionCode = array(), $extraCover = null);
}
