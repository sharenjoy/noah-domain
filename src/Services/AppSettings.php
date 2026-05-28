<?php

declare(strict_types=1);

namespace Sharenjoy\NoahDomain\Services;

use Illuminate\Support\Facades\Cache;

class AppSettings
{
    private const CACHE_KEY = 'settings.all';

    /**
     * Request 等級記憶體快取，避免同一 request 內重複 Redis 查詢。
     *
     * @var array<string, mixed>|null
     */
    private ?array $cache = null;

    /**
     * 取得指定 key 的設定（支援點記法）。
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->all(), $key, $default);
    }

    /**
     * 取得整包設定陣列。
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->cache ??= Cache::rememberForever(
            self::CACHE_KEY,
            fn (): array => setting()->get()
        );
    }
}
