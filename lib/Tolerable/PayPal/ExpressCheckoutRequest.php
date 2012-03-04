<?php
namespace Tolerable\PayPal;

abstract class ExpressCheckoutRequest extends Request
{
    const SALE_PAYMENT_ACTION    = 'Sale';
    const IMMEDIATE_PAYMENT      = 'InstantPaymentOnly';
    
    const TOKEN = 'TOKEN';
    
    const PAYMENT_ACTION         = 'PAYMENTREQUEST_0_PAYMENTACTION';
    const ALLOWED_PAYMENT_METHOD = 'PAYMENTREQUEST_0_ALLOWEDPAYMENTMETHOD';
    const AMOUNT                 = 'PAYMENTREQUEST_0_AMT';
    const CURRENCY_CODE          = 'PAYMENTREQUEST_0_CURRENCYCODE';
    const TOTAL_AMOUNT           = 'PAYMENTREQUEST_0_ITEMAMT';
    const TAX_AMOUNT             = 'PAYMENTREQUEST_0_TAXAMT';
    const SHIPPINGAMT            = 'PAYMENTREQUEST_0_SHIPPINGAMT';
    
    const SHIP_TO_NAME         = 'PAYMENTREQUEST_0_SHIPTONAME';
    const SHIP_TO_STREET       = 'PAYMENTREQUEST_0_SHIPTOSTREET';
    const SHIP_TO_STREET2      = 'PAYMENTREQUEST_0_SHIPTOSTREET2';
    const SHIP_TO_CITY         = 'PAYMENTREQUEST_0_SHIPTOCITY';
    const SHIP_TO_STATE        = 'PAYMENTREQUEST_0_SHIPTOSTATE';
    const SHIP_TO_ZIP          = 'PAYMENTREQUEST_0_SHIPTOZIP';
    const SHIP_TO_COUNTRY_CODE = 'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE';
    const SHIP_TO_PHONE        = 'PAYMENTREQUEST_0_SHIPTOPHONENUM';
    
    const TAX_DENOMINATOR = 11;
    
    protected $token;
    
    protected $paymentAction = self::SALE_PAYMENT_ACTION;
    
    protected $allowedPaymentMethods = self::IMMEDIATE_PAYMENT;
    
    protected $items = array();
    
    protected $currenyCode = 'AUD';
    
    protected $shippingAmount = 0;
    
    protected $shipToName;
    
    protected $shipToStreet;
    
    protected $shipToStreet2;
    
    protected $shipToCity;
    
    protected $shipToState;
    
    protected $shipToZip;
    
    protected $shipToCountry;
    
    protected $shipToPhone;
    
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }
    
    public function setCurrencyCode($currenyCode)
    {
        $this->currenyCode = (string) $currenyCode;
        return $this;
    }
    
    public function setShippingAmount($shippingAmount)
    {
        $this->shippingAmount = (double) $shippingAmount;
        return $this;
    }
    
    public function setShipToName($shipToName)
    {
        $this->shipToName = (string) $shipToName;
        return $this;
    }
    
    public function setShipToStreet($shipToStreet)
    {
        $this->shipToStreet = (string) $shipToStreet;
        return $this;
    }
    
    public function setShipToStreet2($shipToStreet2)
    {
        $this->shipToStreet2 = (string) $shipToStreet2;
        return $this;
    }
    
    public function setShipToCity($shipToCity)
    {
        $this->shipToCity = (string) $shipToCity;
        return $this;
    }
    
    public function setShipToState($shipToState)
    {
        $this->shipToState = (string) $shipToState;
        return $this;
    }
    
    public function setShipToZip($shipToZip)
    {
        $this->shipToZip = (string) $shipToZip;
        return $this;
    }
    
    public function setShipToCountry($shipToCountry)
    {
        $this->shipToCountry = (string) $shipToCountry;
        return $this;
    }
    
    public function setShipToPhone($shipToPhone)
    {
        $this->shipToPhone = (string) $shipToPhone;
        return $this;
    }
    
    public function addItem(Item $item)
    {
        $this->items[] = $item;
        return $this;
    }
    
    public function addItems(array $items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
        
        return $this;
    }
    
    public function toArray()
    {
        $itemTotal = $this->getItemTotal();
        $total = $this->shippingAmount + $itemTotal;
        
        $params = array(
            self::PAYMENT_ACTION         => $this->paymentAction,
            self::ALLOWED_PAYMENT_METHOD => $this->allowedPaymentMethods,
            self::AMOUNT                 => sprintf('%0.2f', $total),
            self::TOTAL_AMOUNT           => sprintf('%0.2f', $itemTotal),
            self::CURRENCY_CODE          => $this->currenyCode,
            self::SHIPPINGAMT            => sprintf('%0.2f', $this->shippingAmount),
        );
        
        if (null !== $this->token) {
            $params[self::TOKEN] = $this->token;
        }
        
        /* @var $item Tolerable_PayPal_Item */
        foreach ($this->items as $i => $item) {
            $params += $item->toArray($i);
        }
        
        return $params + $this->getShippingArray() + parent::toArray();
    }
    
    protected function getShippingArray()
    {
        if (null === $this->shipToName) {
            return array();
        }
        $shipping =  array(
            self::SHIP_TO_NAME         => $this->shipToName,
            self::SHIP_TO_STREET       => $this->shipToStreet,
            self::SHIP_TO_CITY         => $this->shipToCity,
            self::SHIP_TO_STATE        => $this->shipToState,
            self::SHIP_TO_ZIP          => $this->shipToZip,
            self::SHIP_TO_COUNTRY_CODE => $this->shipToCountry
        );
        if ($this->shipToStreet2) {
            $shipping[self::SHIP_TO_STREET2] = $this->shipToStreet2;
        }
        if ($this->shipToPhone) {
            $shipping[self::SHIP_TO_PHONE] = $this->shipToPhone;
        }
        
        return $shipping;
    }
    
    protected function getItemTotal()
    {
        $total = 0;
        /* @var $item Item */
        foreach ($this->items as $item) {
            $total += $item->getTotalAmount();
        }
        return $total;
    }
}
