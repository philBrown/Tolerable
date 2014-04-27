<?php
namespace Tolerable\AusPost;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use \InvalidArgumentException, \RuntimeException;

abstract class Api
{
    const KEY_HEADER = 'AUTH-KEY';
    const FORMAT_XML  = 'xml';
    const FORMAT_JSON = 'json';
    
    private $key;
    
    /**
     * @var ClientInterface
     */
    private $client;
    
    public function __construct(ClientInterface $client, $key)
    {
        $this->setKey($key)
             ->setClient($client);
    }
    
    public function setClient(ClientInterface $client)
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
    
    protected function request($uri, array $params = [])
    {
        if (false === \strpos($uri, self::FORMAT_JSON)) {
            $uri = $uri . '.' . self::FORMAT_JSON;
        }
        
        /* @var $httpRequest \GuzzleHttp\Message\RequestInterface */
        $httpRequest = $this->client->createRequest('GET', $uri, [
            'headers' => [self::KEY_HEADER => $this->key],
            'query'   => $params
        ]);
        
        try {
            $httpResponse = $this->client->send($httpRequest);
        } catch (BadResponseException $bre) {
            $httpResponse = $bre->getResponse();
            if (null === $httpResponse) {
                throw $bre;
            }
        }
            
        $response = $httpResponse->json(['object' => true]);
        if (isset($response->error)) {
            throw new RuntimeException($response->error->errorMessage);
        }

        return $response;
    }
}
