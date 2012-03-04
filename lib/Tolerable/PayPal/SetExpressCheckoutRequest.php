<?php
namespace Tolerable\PayPal;

class SetExpressCheckoutRequest extends ExpressCheckoutRequest
{
    const METHOD = 'SetExpressCheckout';
    
    const DISPLAY_SHIPPING_ADDRESS = 0;
    const HIDE_SHIPPING_ADDRESS    = 1;
    const DEFAULT_SHIPPING_ADDRESS = 2;
    
    const RETURN_URL    = 'RETURNURL';
    const CANCEL_URL    = 'CANCELURL';
    const ALLOW_NOTE    = 'ALLOWNOTE';
    const LOCALE_CODE   = 'LOCALECODE';
    const SHOW_SHIPPING = 'NOSHIPPING';
    
    protected $method = self::METHOD;
    
    protected $showShipping = self::DEFAULT_SHIPPING_ADDRESS;
    
    protected $returnUrl;
    
    protected $cancelUrl;
    
    public function __construct($returnUrl, $cancelUrl)
    {
        $this->setReturnUrl($returnUrl)
             ->setCancelUrl($cancelUrl);
    }
    
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = (string) $returnUrl;
        return $this;
    }
    
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = (string) $cancelUrl;
        return $this;
    }
    
    public function toArray()
    {
        return array(
            self::RETURN_URL    => $this->returnUrl,
            self::CANCEL_URL    => $this->cancelUrl,
            self::ALLOW_NOTE    => 1,
            self::SHOW_SHIPPING => $this->showShipping,
            self::LOCALE_CODE   => 'AU'
        ) + parent::toArray();
    }
}
