<?php
namespace Tolerable\AusPost;

use Guzzle\Service\ClientInterface;
use Guzzle\Http\Exception\BadResponseException;
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
    
    protected function request($uri, array $params = array())
    {
        if (false === \strpos($uri, self::FORMAT_JSON)) {
            $uri = $uri . '.' . self::FORMAT_JSON;
        }
        
        /* @var $httpRequest \Guzzle\Http\Message\RequestInterface */
        $httpRequest = $this->client->get($uri, array(self::KEY_HEADER => $this->key));
        
        /* @var $query \Guzzle\Http\QueryString */
        $query = $httpRequest->getQuery();
        $query->setAggregateFunction(array($query, 'aggregateUsingDuplicates'));
        $query->replace($params);

        try {
            /* @var $httpResponse \Guzzle\Http\Message\Response */
            $httpResponse = $httpRequest->send();

            if ($httpResponse->isError()) {
                throw new RuntimeException($httpResponse->getMessage(), $httpResponse->getStatusCode());
            }
        } catch (BadResponseException $bre) {
            $httpResponse = $bre->getResponse();
        }
            

        $response = \json_decode($httpResponse->getBody(true));
        if (isset($response->error)) {
            throw new RuntimeException($response->error->errorMessage);
        }

        return $response;
    }
}
