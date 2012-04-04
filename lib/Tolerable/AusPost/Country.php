<?php
namespace Tolerable\AusPost;

class Country
{
    private $code;
    
    private $name;
    
    public function __construct($code, $name) {
        $this->code = (string) $code;
        $this->name = (string) $name;
    }
    
    public function getCode() {
        return $this->code;
    }
    
    public function getName() { 
        return $this->name;
    }
}
