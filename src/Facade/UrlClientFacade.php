<?php

namespace Task\Facade;

use GuzzleHttp\Client;
use Task\Exception\UrlClientException;

class UrlClientFacade
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @return string
     * @throws UrlClientException
     */
    public function executeGetRequest(string $url): string
    {
        try {
            $response = $this->client->get($url);
            return $response->getBody()->getContents();
        } catch (\Throwable $exception) {
            throw new UrlClientException($exception->getMessage(), 0, $exception);
        }
    }
}
