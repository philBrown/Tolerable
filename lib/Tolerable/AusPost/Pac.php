<?php
namespace Tolerable\AusPost;

interface Pac
{
    /**
     * @return Response\ListCountriesResponse
     */
    public function listCountries();
    
    /**
     * @return object
     */
    public function listDomesticParcelServices();
    
    /**
     * @return object
     */
    public function listInternationalParcelServices();
    
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
