<?php

declare(strict_types=1);

namespace Omikron\FactFinder\Communication\Resource\NG;

use Omikron\FactFinder\Communication\Client\ClientInterface;
use Omikron\FactFinder\Communication\Resource\Search;

class SearchAdapter implements Search
{
    /** @var ClientInterface */
    private $client;

    /** @var array */
    private $config;

    public function __construct(
        ClientInterface $client,
        array $config = []
    ) {
        $this->client = $client;
        $this->config = $config;
    }

    public function search(string $channel, string $query, array $params = []): array
    {
        $params     = ['query' => $query] + $params;
        $apiVersion = $this->getApiVersion();
        $response   = $this->client->request('GET', "rest/{$apiVersion}/search/{$channel}", ['query' => $params]);
        return (array) json_decode((string) $response->getBody(), true);
    }

    public function suggest(string $channel, string $query, array $params = []): array
    {
        $params     = ['query' => $query] + $params;
        $apiVersion = $this->getApiVersion();
        $response   = $this->client->request('GET', "rest/{$apiVersion}/suggest/{$channel}", ['query' => $params]);
        return (array) json_decode((string) $response->getBody(), true);
    }

    private function getApiVersion(): string
    {
        return (string) $this->config['api_version'] ?? 'v4';
    }
}
