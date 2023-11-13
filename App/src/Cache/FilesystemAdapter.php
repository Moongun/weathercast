<?php

declare(strict_types=1);

namespace App\Cache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter as BaseFilesystemAdapter;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

class FilesystemAdapter extends BaseFilesystemAdapter implements CacheAdapterInterface
{
    // todo: directory should be more generic (depending on env)
    private const DIRECTORY = '/code/var/cache/dev';
    private const DEFAULT_LIFETIME = 3600;
    private const NAMESPACE = 'app';

    public function __construct(string $namespace = self::NAMESPACE, int $defaultLifetime = self::DEFAULT_LIFETIME, MarshallerInterface $marshaller = null)
    {
        parent::__construct($namespace, $defaultLifetime, self::DIRECTORY, $marshaller);
    }

    public function processItem(string $key, callable $callback): mixed
    {
        return $this->get($key, $callback);
    }
}
