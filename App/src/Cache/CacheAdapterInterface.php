<?php

declare(strict_types=1);

namespace App\Cache;

interface CacheAdapterInterface
{
    public function processItem(string $key, callable $callback): mixed;
}
