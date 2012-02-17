<?php

namespace Tolerable\AusPost;

use \Zend_Http_Client;
use \InvalidArgumentException, \RuntimeException;

abstract class Api
{
    const KEY_HEADER = 'AUTH-KEY';
    const FORMAT_XML  = 'xml';
    const FORMAT_JSON = 'json';
    
    private $key;
    
    /**
     * @var Zend_Http_Client
     */
    private $client;
    
    public function __construct(Zend_Http_Client $client, $key)
    {
        $this->setKey($key)
             ->setClient($client);
        
        $this->client->setHeaders(self::KEY_HEADER, $this->key);
    }
    
    public function setClient(Zend_Http_Client $client)
    {
        $this->client = $client;
        return $this;
    }
    
    public function setKey($key)
    {
        $key = (string) $key;
        if (strlen($key) != 32) {
            throw new InvalidArgumentException('Australia Post API keys must be 32 characters long');
        }
        $this->key = $key;
        return $this;
    }
    
    protected function request($uri, array $params = array())
    {
        if (false === strpos($uri, self::FORMAT_JSON)) {
            $uri = $uri . '.' . self::FORMAT_JSON;
        }
        
        $this->client->setUri($uri)
                     ->resetParameters()
                     ->setParameterGet($params);
        $httpResponse = $this->client->request('GET');

        if ($httpResponse->isError()) {
            throw new RuntimeException($httpResponse->getMessage(), $httpResponse->getStatus());
        }

        $response = json_decode($httpResponse->getBody());
        if (isset($response->error)) {
            throw new RuntimeException($response->error->errorMessage);
        }
        
        return $response;
    }
}
