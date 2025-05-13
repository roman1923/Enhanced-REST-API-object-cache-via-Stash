<?php

declare(strict_types=1);

namespace Syde\RestEnhancer\Infrastructure;

use Stash\Interfaces\DriverInterface;
use Stash\Pool;

final class SafePool
{
    private Pool $pool;

    public function __construct(?DriverInterface $driver = null)
    {}

    public function getItem($key): \Stash\Interfaces\ItemInterface
    {
        return $this->pool->getItem($key);
    }

    public function save(\Stash\Interfaces\ItemInterface $item): bool
    {
        return $this->pool->save($item);
    }

    public function clear(): bool
    {
        return $this->pool->clear();
    }

    public function purge(): bool
    {
        return $this->pool->purge();
    }

    public function setDriver(DriverInterface $driver): void
    {
        $this->pool->setDriver($driver);
    }

    public function getDriver(): DriverInterface
    {
        return $this->pool->getDriver();
    }
}
