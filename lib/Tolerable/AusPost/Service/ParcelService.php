<?php
namespace Tolerable\AusPost\Service;

class ParcelService implements \Countable, \IteratorAggregate, \ArrayAccess {
    /**
     * @var string
     */
    private $code;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var double
     */
    private $price;
    
    /**
     * @var double
     */
    private $maxExtraCover;
    
    /**
     * @var array
     */
    private $options = array();
    
    public function __construct($code, $name) {
        $this->setCode($code)
             ->setName($name);
    }
    
    public function __toString() {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * @param string $code
     * @return ParcelService
     */
    public function setCode($code)
    {
        $this->code = (string) $code;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return ParcelService
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }
    
    /**
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * @param double $price
     * @return ParcelService
     */
    public function setPrice($price)
    {
        $this->price = (double) $price;
        return $this;
    }
    
    /**
     * @return double
     */
    public function getMaxExtraCover()
    {
        return $this->maxExtraCover;
    }
    
    /**
     * @param double $maxExtraCover
     * @return ParcelService
     */
    public function setMaxExtraCover($maxExtraCover)
    {
        $this->maxExtraCover = (double) $maxExtraCover;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    public function addOption(ParcelServiceOption $option) {
        $this->options[$option->getCode()] = $option;
        return $this;
    }
    
    public function hasOption($code) {
        return \array_key_exists($code, $this->options);
    }
    
    public function getOption($code) {
        if ($this->hasOption($code)) {
            return $this->options[$code];
        }
        return null;
    }

    public function count() {
        return \count($this->options);
    }

    public function getIterator() {
        return new \ArrayIterator($this->options);
    }

    public function offsetExists($offset) {
        return $this->hasOption($offset);
    }

    public function offsetGet($offset) {
        return $this->getOption($offset);
    }

    public function offsetSet($offset, $value) {
        return $this->addOption($value);
    }

    public function offsetUnset($offset) {
        return;
    }
}