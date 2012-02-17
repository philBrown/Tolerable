<?php
namespace Tolerable\PayPal;

use \Exception;

class Response
{
    const SET_EXPRESS_CHECKOUT         = 'SetExpressCheckout';
    const GET_EXPRESS_CHECKOUT_DETAILS = 'GetExpressCheckoutDetails';
    const DO_EXPRESS_CHECKOUT_PAYMENT  = 'DoExpressCheckoutPayment';
    
    const TIMESTAMP           = 'TIMESTAMP';
    const CORRELATION_ID      = 'CORRELATIONID';
    const ACK                 = 'ACK';
    const VERSION             = 'VERSION';
    const BUILD               = 'BUILD';
    const TOKEN               = 'TOKEN';
    const ERROR_CODE          = 'L_ERRORCODE0';
    const SHORT_ERROR_MESSAGE = 'L_SHORTMESSAGE0';
    const LONG_ERROR_MESSAGE  = 'L_LONGMESSAGE0';
    const SEVERITY_CODE       = 'L_SEVERITYCODE0';
    
    const ACK_SUCCESS = 'Success';
    
    protected $timestamp;
    
    protected $correlationId;
    
    protected $ack;
    
    protected $version;
    
    protected $build;
    
    protected $token;
    
    protected $errorCode;
    
    protected $shortErrorMessage;
    
    protected $longErrorMessage;
    
    protected $severityCode;
    
    /**
     * Build a response object based on the type of request
     * 
     * @param string $method
     * @param string $response NVP string from Tolerable_PayPal
     * @return Response 
     */
    public static function factory($method, $response)
    {
        parse_str($response, $data);
        
        switch ($method) {
            case self::SET_EXPRESS_CHECKOUT :
                return new Tolerable_PayPal_Response($data);
            case self::GET_EXPRESS_CHECKOUT_DETAILS :
                // TODO Implement GetExpressCheckoutDetailsResponse
            case self::DO_EXPRESS_CHECKOUT_PAYMENT :
                return new DoExpressCheckoutPaymentResponse($data);
            default :
                throw new Exception(sprintf('Unknown method "%s"', $method));
        }
    }
    
    private function __construct(array $data)
    {
        $this->setData($data);
    }
    
    protected function setData(array $data)
    {
        if (array_key_exists(self::TIMESTAMP, $data)) {
            $this->timestamp = $data[self::TIMESTAMP];
        }
        if (array_key_exists(self::CORRELATION_ID, $data)) {
            $this->correlationId = $data[self::CORRELATION_ID];
        }
        if (array_key_exists(self::ACK, $data)) {
            $this->ack = $data[self::ACK];
        }
        if (array_key_exists(self::VERSION, $data)) {
            $this->version = $data[self::VERSION];
        }
        if (array_key_exists(self::BUILD, $data)) {
            $this->build = $data[self::BUILD];
        }
        if (array_key_exists(self::TOKEN, $data)) {
            $this->token = $data[self::TOKEN];
        }
        if (array_key_exists(self::ERROR_CODE, $data)) {
            $this->errorCode = $data[self::ERROR_CODE];
        }
        if (array_key_exists(self::SHORT_ERROR_MESSAGE, $data)) {
            $this->shortErrorMessage = $data[self::SHORT_ERROR_MESSAGE];
        }
        if (array_key_exists(self::LONG_ERROR_MESSAGE, $data)) {
            $this->longErrorMessage = $data[self::LONG_ERROR_MESSAGE];
        }
        if (array_key_exists(self::SEVERITY_CODE, $data)) {
            $this->severityCode = $data[self::SEVERITY_CODE];
        }
    }
    
    public function isError()
    {
        return $this->ack != self::ACK_SUCCESS;
    }
    
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    
    public function getCorrelationId()
    {
        return $this->correlationId;
    }
    
    public function getToken()
    {
        return $this->token;
    }
    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function getBuild()
    {
        return $this->build;
    }
    
    public function getErrorCode()
    {
        return $this->errorCode;
    }
    
    public function getShortErrorMessage()
    {
        return $this->shortErrorMessage;
    }
    
    public function getLongErrorMessage()
    {
        return $this->longErrorMessage;
    }
    
    public function getSeverityCode()
    {
        return $this->severityCode;
    }
}
