<?php
namespace Tolerable\AusPost;

use GuzzleHttp\Client;

class PacIntegrationTest extends \PHPUnit_Framework_TestCase
{

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

    /**
     * @todo Implement testCalculateDomesticParcelPostage().
     */
    public function testCalculateDomesticParcelPostage()
    {
        $result = $this->pac->calculateDomesticParcelPostage(3000, 3000, 23, 13,
                3.5, 0.523, 'AUS_PARCEL_REGULAR',
                'AUS_SERVICE_OPTION_STANDARD');
        $this->assertGreaterThan(0, \count($result->getCosts()));
        $this->assertEquals('AUS_PARCEL_REGULAR', $result->getService());
    }

    /**
     * @todo Implement testCalculateInternationalParcelPostage().
     */
    public function testCalculateInternationalParcelPostage()
    {
        $result = $this->pac->calculateInternationalParcelPostage('NZ', 3, 'INTL_SERVICE_AIR_MAIL');
        $this->assertGreaterThan(0, \count($result->getCosts()));
        $this->assertEquals('INTL_SERVICE_AIR_MAIL', $result->getService());
    }

    /**
     * @todo Implement testListCountries().
     */
    public function testListCountries()
    {
        $list = $this->pac->listCountries();
        $this->assertGreaterThan(0, \count($list));
    }

    /**
     * @todo Implement testListDomesticParcelServices().
     */
    public function testListDomesticParcelServices()
    {
        $list = $this->pac->listDomesticParcelServices(3000, 3000, 23, 13, 3.5, 0.523);
        $this->assertGreaterThan(0, \count($list));
    }

    /**
     * @todo Implement testListInternationalParcelServices().
     */
    public function testListInternationalParcelServices()
    {
        $list = $this->pac->listInternationalParcelServices('GB', 0.523);
        $this->assertGreaterThan(0, \count($list));
    }
}
