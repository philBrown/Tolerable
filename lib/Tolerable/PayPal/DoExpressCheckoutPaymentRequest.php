<?php
namespace Tolerable\PayPal;

class DoExpressCheckoutPaymentRequest extends ExpressCheckoutRequest
{
    const METHOD = 'DoExpressCheckoutPayment';
    
    const PAYER_ID = 'PAYERID';
    
    protected $method = self::METHOD;
    
    protected $payerId;
    
    public function __construct($payerId)
    {
        $this->setPayerId($payerId);
    }
    
    public function setPayerId($payerId)
    {
        $this->payerId = $payerId;
        return $this;
    }
    
    public function toArray()
    {
        return array(
            self::PAYER_ID => $this->payerId
        ) + parent::toArray();
    }
}
