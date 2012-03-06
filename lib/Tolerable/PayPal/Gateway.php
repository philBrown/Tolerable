<?php
namespace Tolerable\PayPal;

use Guzzle\Service\ClientInterface;
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
     * @var ClientInterface
     */
    private $client;
    
    private $webServiceUrl = self::WS_URL;

    public function __construct(ClientInterface $client, $username, $password, $signature)
    {
        $this->setUsername($username)
             ->setPassword($password)
             ->setSignature($signature)
             ->setClient($client);
    }
    
    public function setWebServiceUrl($webServiceUrl)
    {
        $this->webServiceUrl = (string) $webServiceUrl;
        return $this;
    }
    
    public function setClient(ClientInterface $client)
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
        
        /* @var $httpRequest \Guzzle\Http\Message\RequestInterface */
        $httpRequest = $this->client->post($this->webServiceUrl, array(), $params);
        
        /* @var $httpResponse \Guzzle\Http\Message\Response */
        $httpResponse = $httpRequest->send();
        
        if ($httpResponse->isError()) {
            throw new Exception($httpResponse->getMessage(), $httpResponse->getStatusCode());
        }
        
        $response = Response::factory($request->getMethod(), $httpResponse->getBody(true));
        
        if ($response->isError()) {
            throw new Exception($response->getLongErrorMessage(), $response->getErrorCode());
        }
        return $response;
    }
    
}