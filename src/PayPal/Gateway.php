<?php
namespace Tolerable\PayPal;

use Tolerable\PayPal\Request\Request;
use Tolerable\PayPal\Request\SetExpressCheckoutRequest;
use Tolerable\PayPal\Request\GetExpressCheckoutDetailsRequest;
use Tolerable\PayPal\Request\DoExpressCheckoutPaymentRequest;
use Tolerable\PayPal\Response\Response;

use GuzzleHttp\ClientInterface;
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
    
    private $webServiceUrl;
    
    private $redirectUrl;

    public function __construct(ClientInterface $client, $username, $password, $signature,
            $webServiceUrl = self::WS_URL, $redirectUrl = self::PAYPAL_URL)
    {
        $this->setUsername($username)
             ->setPassword($password)
             ->setSignature($signature)
             ->setClient($client)
             ->setWebServiceUrl($webServiceUrl)
             ->setRedirectUrl($redirectUrl);
    }
    
    public function setWebServiceUrl($webServiceUrl)
    {
        $this->webServiceUrl = (string) $webServiceUrl;
        return $this;
    }
    
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = (string) $redirectUrl;
        return $this;
    }
    
    public function getRedirectUrl($token)
    {
        return sprintf('%s?cmd=_express-checkout&token=%s',
                $this->redirectUrl, $token);
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
     * @param SetExpressCheckoutRequest $request
     * @return Response
     */
    public function setExpressCheckout(SetExpressCheckoutRequest $request)
    {
        return $this->request($request);
    }
    
    /**
     * @param GetExpressCheckoutDetailsRequest $request
     * @return Response\GetExpressCheckoutDetailsResponse 
     */
    public function getExpressCheckoutDetails(GetExpressCheckoutDetailsRequest $request)
    {
        return $this->request($request);
    }
    
    /**
     * @param DoExpressCheckoutPaymentRequest $request
     * @return DoExpressCheckoutPaymentResponse
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
        
        $httpResponse = $this->client->post($this->webServiceUrl, ['body' => $params]);
        
        $response = Response::factory($request->getMethod(), $httpResponse->getBody());
        
        if ($response->isError()) {
            throw new Exception($response->getLongErrorMessage(), $response->getErrorCode());
        }
        return $response;
    }
    
}