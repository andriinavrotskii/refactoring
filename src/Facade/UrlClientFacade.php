<?php

declare(strict_types=1);

namespace Task\Facade;

use GuzzleHttp\Client;
use Task\Exception\NotFoundException;
use Task\Exception\UrlClientException;
use Task\Repository\CacheRepository;

class UrlClientFacade
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * UrlClientFacade constructor.
     * @param Client $client
     * @param CacheRepository $cacheRepository
     */
    public function __construct(Client $client, CacheRepository $cacheRepository)
    {
        $this->client = $client;
        $this->cacheRepository = $cacheRepository;
    }

    /**
     * @param string $url
     * @return string
     * @throws UrlClientException
     * @throws NotFoundException
     */
    public function executeGetRequest(string $url): string
    {
        if ($this->cacheRepository->isKeyExists($url)) {
            $content = $this->cacheRepository->getFromStorage($url);
        } else {
            $content = $this->doRequest($url);
            $this->cacheRepository->setToStorage($url, $content);
        }

        return $content;
    }

    /**
     * @param string $url
     * @return string
     * @throws UrlClientException
     */
    private function doRequest(string $url): string
    {
        try {
            $response = $this->client->get($url);
            return $response->getBody()->getContents();
        } catch (\Throwable $exception) {
            throw new UrlClientException($exception->getMessage(), 0, $exception);
        }
    }
}
