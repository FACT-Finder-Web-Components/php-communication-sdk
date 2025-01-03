<?php

declare(strict_types=1);

namespace Omikron\FactFinder\Communication\Resource\NG;

use Omikron\FactFinder\Communication\Client\ClientInterface;
use Omikron\FactFinder\Communication\Resource\Import;

class ImportAdapter implements Import
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

    public function import(string $channel, string $type, array $params = []): array
    {
        $params     = ['channel' => $channel] + $params;
        $apiVersion = $this->getApiVersion();
        $response   = $this->client->request('POST', "rest/{$apiVersion}/import/{$type}", ['query' => $params]);
        return (array) json_decode((string) $response->getBody(), true);
    }

    public function running(string $channel): bool
    {
        $apiVersion = $this->getApiVersion();
        $response   = $this->client->request('GET', "rest/{$apiVersion}/import/running", ['query' => ['channel' => $channel]]);
        return (bool) json_decode((string) $response->getBody(), true);
    }

    private function getApiVersion(): string
    {
        return (string) ($this->config['api_version'] ?? 'v4');
    }
}
