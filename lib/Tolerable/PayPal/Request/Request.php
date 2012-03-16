<?php
namespace Tolerable\PayPal\Request;

abstract class Request
{
    const API_CURRENT_VERSION = '84.0';
    
    const VERSION = 'VERSION';
    const METHOD  = 'METHOD';
    
    protected $apiVersion = self::API_CURRENT_VERSION;
    
    protected $method;
    
    public function toArray()
    {
        return array(
            self::VERSION => $this->apiVersion,
            self::METHOD  => $this->method
        );
    }
    
    public function toString()
    {
        return \implode('&', $this->toArray());
    }
    
    public function __toString()
    {
        return $this->toString();
    }
    
    public function getMethod()
    {
        return $this->method;
    }
}
