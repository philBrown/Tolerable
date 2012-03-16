<?php
namespace Tolerable\PayPal\Request;

class GetExpressCheckoutDetailsRequest extends Request
{
    const METHOD = 'GetExpressCheckoutDetails';
    
    const TOKEN  = 'TOKEN';
    
    protected $method = self::METHOD;
    
    protected $token;
    
    public function __construct($token)
    {
        $this->token = (string) $token;
    }
    
    public function toArray()
    {
        return array(
            self::TOKEN => $this->token
        ) + parent::toArray();
    }
}
