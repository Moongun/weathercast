<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\RequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractRequest
{
    protected function isSuccessful(ResponseInterface $response): void
    {
        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new RequestException(sprintf('Call of %s failed with code %s', static::class, $response->getStatusCode()));
        }
    }
}
