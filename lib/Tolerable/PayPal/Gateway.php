<?php
namespace Tolerable\PayPal;

use \Zend_Http_Client;
use \Exception;

class Gateway
{
    const WS_URL         = 'https://api-3t.paypal.com/nvp';
    const SANDBOX_WS_URL = 'https://api-3t.sandbox.paypal.com/nvp';
    
    const PAYPAL_URL         = 'https://www.paypal.com/webscr';
    const PAYPAL_SANDBOX_URL = 'https://www.sandbox.paypal.com/webscr';
    
    const USERNAME  = 'USER';
    const PASSWORD  = 'PWD';
    const SIGNATURE = 'SIGNATURE';
    
    private $username;
    
    private $password;
    
    private $signature;
    
    /**
     * @var Zend_Http_Client
     */
    private $client;

    public function __construct(Zend_Http_Client $client, $username, $password, $signature)
    {
        $this->setUsername($username)
             ->setPassword($password)
             ->setSignature($signature)
             ->setClient($client);
    }
    
    public function setClient(Zend_Http_Client $client)
    {
        $this->client = $client;
        return $this;
    }
    
    public function setUsername($username)
    {
        $this->username = (string) $username;
        return $this;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function setPassword($password)
    {
        $this->password = (string) $password;
        return $this;
    }
    
    public function setSignature($signature)
    {
        $this->signature = (string) $signature;
        return $this;
    }

    /**
     * @param Tolerable_PayPal_SetExpressCheckoutRequest $request
     * @return Tolerable_PayPal_Response
     */
    public function setExpressCheckout(SetExpressCheckoutRequest $request)
    {
        return $this->request($request);
    }
    
    /**
     * @param Tolerable_PayPal_DoExpressCheckoutPaymentRequest $request
     * @return Tolerable_PayPal_DoExpressCheckoutPaymentResponse
     */
    public function doExpressCheckoutPayment(DoExpressCheckoutPaymentRequest $request)
    {
        return $this->request($request);
    }
    
    private function request(Request $request)
    {
        $params = array(
            self::USERNAME  => $this->username,
            self::PASSWORD  => $this->password,
            self::SIGNATURE => $this->signature
        ) + $request->toArray();
        
        $this->client->resetParameters()->setParameterPost($params);
        $httpResponse = $this->client->request('POST');
        
        if ($httpResponse->isError()) {
            throw new Exception($httpResponse->getMessage(), $httpResponse->getStatus());
        }
        
        $response = Tolerable_PayPal_Response::factory($request->getMethod(), $httpResponse->getBody());
        
        if ($response->isError()) {
            throw new Exception($response->getLongErrorMessage(), $response->getErrorCode());
        }
        return $response;
    }
    
}