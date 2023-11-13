<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface RequestInterface
{
    public function call(array $inputData = []): ResponseInterface;
}
