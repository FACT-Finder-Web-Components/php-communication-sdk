<?php

declare(strict_types=1);

namespace Omikron\FactFinder\Communication\Client\Middleware;

use Psr\Http\Message\RequestInterface;

class QueryArrayNormalizer
{
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {

            $uri = $request->getUri();
            $query = $uri->getQuery();

            if (!$query) {
                return $handler($request, $options);
            }

            parse_str($query, $params);

            $normalized = [];

            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        $normalized[] = rawurlencode($key) . '=' . rawurlencode((string) $v);
                    }
                } else {
                    $normalized[] = rawurlencode($key) . '=' . rawurlencode((string) $value);
                }
            }

            $newQuery = implode('&', $normalized);

            $request = $request->withUri(
                $uri->withQuery($newQuery)
            );

            return $handler($request, $options);
        };
    }
}