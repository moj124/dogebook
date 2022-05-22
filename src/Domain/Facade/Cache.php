<?php

namespace App\Domain\Facade;

use Symfony\Component\Cache\Adapter\FilesystemTagAwareAdapter;

class Cache
{
    /**
     * @inheritDoc
     */
    private static FilesystemTagAwareAdapter $cache;

    public static function __callStatic($method, $arguments)
    {
        
        if (!isset(self::$cache)) {
            self::$cache = new FilesystemTagAwareAdapter('doge_cache');
        }

        return self::$cache->$method(...$arguments);
    }
}
