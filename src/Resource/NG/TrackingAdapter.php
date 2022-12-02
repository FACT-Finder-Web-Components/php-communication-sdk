<?php

declare(strict_types=1);

namespace Omikron\FactFinder\Communication\Resource\NG;

use Omikron\FactFinder\Communication\Client\ClientInterface;
use Omikron\FactFinder\Communication\Resource\Tracking;

class TrackingAdapter implements Tracking
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

    public function track(string $channel, string $event, array $eventData = []): array
    {
        $params   = ['body' => json_encode($eventData), 'headers' => ['Content-Type' => 'application/json']];
        $apiVersion = $this->getApiVersion();
        $response = $this->client->request('POST', "rest/{$apiVersion}/track/{$channel}/{$event}", $params);
        return json_decode((string) $response->getBody(), true) ?? [];
    }

    private function getApiVersion(): string
    {
        return (string) $this->config['api_version'] ?? 'v4';
    }
}
