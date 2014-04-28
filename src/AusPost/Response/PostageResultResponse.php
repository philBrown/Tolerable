<?php
namespace Tolerable\AusPost\Response;

use Tolerable\AusPost\Postage\Cost;

class PostageResultResponse {
    private $service;
    
    private $deliveryTime;
    
    private $totalCost;
    
    private $costs = [];
    
    public function __construct($service, $totalCost) {
        $this->service = (string) $service;
        $this->totalCost = (double) $totalCost;
    }
    
    public function getService() {
        return $this->service;
    }
    
    public function setDeliveryTime($deliveryTime) {
        $this->deliveryTime = $deliveryTime;
        return $this;
    }
    
    public function getDeliveryTime() {
        return $this->deliveryTime;
    }
    
    public function getTotalCost() {
        return $this->totalCost;
    }
    
    public function getCosts() {
        return $this->costs;
    }
    
    public function addCost(Cost $cost) {
        $this->costs[] = $cost;
    }
    
    public function toString($extraCover = null) {
        $str = $this->service . '.';
        /* @var $cost Cost */
        foreach ($this->costs as $cost) {
            $str .= "\n * " . $cost->getItem();
        }
        if (null !== $extraCover) {
            $str .= \sprintf("\nExtra Cover: $%.2f", $extraCover);
        }
        return $str;
    }
}
