<?php
namespace Tolerable\AusPost\Service;

class ParcelServiceSubOption {
    private $code;
    
    private $name;
    
    public function __construct($code, $name) {
        $this->setCode($code)
             ->setName($name);
    }
    
    public function setCode($code) {
        $this->code = (string) $code;
        return $this;
    }
    
    public function getCode() {
        return $this->code;
    }
    
    public function setName($name) {
        $this->name = (string) $name;
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function __toString() {
        return $this->getName();
    }
}
