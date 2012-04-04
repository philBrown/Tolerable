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
            'curl.CURLOPT_SSL_VERIFYHOST' => false,
            'curl.CURLOPT_SSL_VERIFYPEER' => false,
        ));
        $this->pac = new PacImpl($client, 'RK445xsvJetnJrrQuZXCYybTDqcf61jd');
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
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testCalculateInternationalParcelPostage().
     */
    public function testCalculateInternationalParcelPostage()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
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
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testListInternationalParcelServices().
     */
    public function testListInternationalParcelServices()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
