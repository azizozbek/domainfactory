<?php

namespace App\Services;

class CacheService
{
    private string $cachePath;
    public static CacheService|null $inherit = null;

    private function __construct()
    {
        $this->cachePath = __DIR__ . '/../../cache';

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }

    public static function getInstance(): self
    {
        if (null === self::$inherit) {
            self::$inherit = new self();
        }

        return self::$inherit;
    }

    public function get(string $key): mixed
    {
        $file = $this->filePath($key);

        if (!file_exists($file)) {
            return null;
        }

        $data = json_decode(file_get_contents($file), true);

        // expired
        if (time() > $data['expires_at']) {
            unlink($file);
            return null;
        }

        return $data['value'];
    }

    public function set(string $key, mixed $value, int $ttl = 300): void
    {
        $data = [
            'value'      => $value,
            'expires_at' => time() + $ttl,
        ];

        file_put_contents($this->filePath($key), json_encode($data));
    }

    public function forget(string $key): void
    {
        $file = $this->filePath($key);

        if (file_exists($file)) {
            unlink($file);
        }
    }

    private function filePath(string $key): string
    {
        return $this->cachePath . '/' . md5($key) . '.cache';
    }
}