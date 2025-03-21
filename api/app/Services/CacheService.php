<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class CacheService
{
    /**
     * Append a record to a cached list, JSON, hash, or set in Redis.
     *
     * @param string $cacheKey
     * @param mixed $newRecord
     * @param string $type The type of cache storage ('list', 'json', 'hash', or 'set')
     * @param int|\DateTimeInterface $ttl The time to live (cache expiry)
     * @return void
     */
    public function append($cacheKey, $newRecord, $type = 'list', $ttl = 3600)
    {
        $existingRecords = Redis::get($cacheKey);

        switch ($type) {
            case 'list':
                Redis::rpush($cacheKey, json_encode($newRecord));
                break;

            case 'json':
                $existingRecords = json_decode($existingRecords, true) ?: [];
                $existingRecords[] = $newRecord;
                Redis::set($cacheKey, json_encode($existingRecords));
                break;

            case 'hash':
                $existingRecords = json_decode($existingRecords, true) ?: [];
                $existingRecords[$newRecord['id']] = $newRecord;
                Redis::set($cacheKey, json_encode($existingRecords));
                break;

            case 'set':
                Redis::sadd($cacheKey, json_encode($newRecord));
                break;

            default:
                throw new \InvalidArgumentException('Invalid cache type provided.');
        }

        Redis::expire($cacheKey, $ttl);
    }

    /**
     * Retrieve records from Redis cache.
     *
     * @param string $cacheKey
     * @param string $type The type of cache storage ('list', 'json', 'hash', or 'set')
     * @return mixed
     */
    public function retrieve($cacheKey, $type = 'list')
    {
        $cachedData = Redis::get($cacheKey);

        switch ($type) {
            case 'list':
                return Redis::lrange($cacheKey, 0, -1);

            case 'json':
                return json_decode($cachedData, true) ?: [];

            case 'hash':
                return json_decode($cachedData, true) ?: [];

            case 'set':
                return Redis::smembers($cacheKey);

            default:
                throw new \InvalidArgumentException('Invalid cache type provided.');
        }
    }

    public function remove($key)
    {
        Redis::del($key);
    }

    public function replace($key, $value, $ttl = 3600)
    {
        Redis::del($key);
        $this->append($key, $value, 'json');
    }
}
