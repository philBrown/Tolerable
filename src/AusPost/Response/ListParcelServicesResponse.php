<?php
namespace Tolerable\AusPost\Response;

use Tolerable\AusPost\Service\ParcelService;

class ListParcelServicesResponse implements \IteratorAggregate, \ArrayAccess, \Countable {
    /**
     * @var array
     */
    private $services = array();
    
    public function addService(ParcelService $service) {
        $this->services[$service->getCode()] = $service;
        return $this;
    }
    
    public function hasService($code) {
        return \array_key_exists($code, $this->services);
    }
    
    public function getServices() {
        return $this->services;
    }
    
    /**
     * @param string $code
     * @return ParcelService 
     */
    public function getService($code) {
        if ($this->hasService($code)) {
            return $this->services[$code];
        }
        return null;
    }

    public function count() {
        return \count($this->services);
    }

    public function getIterator() {
        return new \ArrayIterator($this->services);
    }

    public function offsetExists($offset) {
        return $this->hasService($offset);
    }

    /**
     * @param string $offset
     * @return ParcelService 
     */
    public function offsetGet($offset) {
        return $this->getService($offset);
    }

    public function offsetSet($offset, $value) {
        return $this->addService($value);
    }

    public function offsetUnset($offset) {
        return;
    }
    
    public function toArray() {
        return $this->services;
    }
}
