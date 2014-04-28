<?php
namespace Tolerable\AusPost;

use GuzzleHttp\Client;

class PacIntegrationTest extends \PHPUnit_Framework_TestCase
{
    private $fromPostcode = 3000;
    private $toPostcode = 3000;
    private $length = 23;
    private $width = 13;
    private $height = 3.5;
    private $weight = 0.523;
    private $countryCode = 'NZ';

    /**
     * @var Pac
     */
    protected $pac;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->pac = new PacImpl(new Client(), getenv('AUSPOST_API_KEY'));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testCalculateDomesticParcelPostage()
    {
        $services = $this->pac->listDomesticParcelServices($this->fromPostcode,
                $this->toPostcode, $this->length, $this->width, $this->height,
                $this->weight);
        $this->assertGreaterThan(0, \count($services), 'Expecting at least one domestic parcel service');
        
        /* @var $service Service\ParcelService */
        foreach ($services as $service) {
            // test default service option
            $result = $this->getDomesticeParcelCalculationResult($service->getCode());
            $this->assertGreaterThan(0, \count($result->getCosts()),
                    \sprintf('Expecting at least one cost for domestic service [%s]', $service->getCode()));
            
            // test service options
            /* @var $option Service\ParcelServiceOption */
            foreach ($service->getOptions() as $option) {
                $result = $this->getDomesticeParcelCalculationResult(
                        $service->getCode(), $option->getCode());
                $this->assertGreaterThan(0, \count($result->getCosts()),
                        \sprintf('Expecting at least one cost for domestic service [%s] with option [%s]', $service->getCode(), $option->getCode()));
            }
        }
    }

    public function testCalculateInternationalParcelPostage()
    {
        $countries = $this->pac->listCountries();
        $this->assertTrue($countries->hasCountry($this->countryCode), 'Nominated test country not found');
        
        $services = $this->pac->listInternationalParcelServices($this->countryCode, $this->weight);
        $this->assertGreaterThan(0, \count($services), 'Expecting at least one international parcel service');
        
        /* @var $service Service\ParcelService */
        foreach ($services as $service) {
            // test default service
            $default = $this->getInternationalParcelCalculationResult($service->getCode());
            $this->assertGreaterThan(0, \count($default->getCosts()));
            
            // test service options
            $result = $this->getInternationalParcelCalculationResult($service->getCode(),
                    $service->getOptionCodes());
            $this->assertGreaterThan(0, \count($result->getCosts()));
        }
    }

    /**
     * @return Response\PostageResultResponse
     */
    private function getDomesticeParcelCalculationResult($service, $option = null, array $subOptions = []) {
        return $this->pac->calculateDomesticParcelPostage($this->fromPostcode,
                $this->toPostcode, $this->length, $this->width, $this->height,
                $this->weight, $service, $option, $subOptions);
    }
    
    /**
     * @return Response\PostageResultResponse
     */
    private function getInternationalParcelCalculationResult($service, array $options = []) {
        return $this->pac->calculateInternationalParcelPostage($this->countryCode,
                $this->weight, $service, $options, 10);
    }
}
