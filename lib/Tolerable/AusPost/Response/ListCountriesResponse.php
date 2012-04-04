<?php
namespace Tolerable\AusPost\Response;

use Tolerable\AusPost\Country;

class ListCountriesResponse implements \IteratorAggregate, \ArrayAccess, \Countable {
    private $countries = array();
    
    public function addCountry(Country $country) {
        $this->countries[$country->getCode()] = $country;
        return $this;
    }
    
    public function hasCountry($code) {
        return \array_key_exists($code, $this->countries);
    }
    
    public function getCountry($code) {
        if (\array_key_exists($code, $this->countries)) {
            return $this->countries[$code];
        }
        return null;
    }
    
    public function removeCountry($code) {
        if ($this->hasCountry($code)) {
            unset($this->countries[$code]);
        }
        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->countries);
    }

    public function offsetExists($offset)
    {
        return $this->hasCountry($offset);
    }

    public function offsetGet($offset)
    {
        return $this->getCountry($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->addCountry($value);
    }

    public function offsetUnset($offset)
    {
        return $this->removeCountry($offset);
    }

    public function count()
    {
        return \count($this->countries);
    }
}
