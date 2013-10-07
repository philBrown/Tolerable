<?php
namespace Tolerable\AusPost;

use \PHPUnit_Framework_TestCase;
use Guzzle\Service\Client;

class PacImplTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var PacImpl
     */
    protected $pac;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $client = new Client();
        $client->setConfig(array(
            'ssl.certificate_authority' => 'system',
            'curl.options' => array(
                CURLOPT_SSL_VERIFYPEER => false
            )
        ));
        $this->pac = new PacImpl($client, 'insert your API code here');
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
                'AUS_SERVICE_OPTION_REGISTERED_POST');
        $this->assertGreaterThan(0, \count($result->getCosts()));
    }

    /**
     * @todo Implement testCalculateInternationalParcelPostage().
     */
    public function testCalculateInternationalParcelPostage()
    {
        $result = $this->pac->calculateInternationalParcelPostage('NZ', 3, 'INTL_SERVICE_AIR_MAIL');
        $this->assertGreaterThan(0, \count($result->getCosts()));
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
