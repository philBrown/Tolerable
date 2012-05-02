<?php
namespace Tolerable\AusPost\Postage;

class Cost {
    /**
     * @var double
     */
    private $cost;
    
    /**
     * @var string
     */
    private $item;
    
    public function __construct($cost, $item) {
        $this->cost = (double) $cost;
        $this->item = (string) $item;
    }
    
    public function getCost() {
        return $this->cost;
    }
    
    public function getItem() {
        return $this->item;
    }
}
