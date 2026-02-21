<?php

namespace App;

use Dotenv\Dotenv;

class Config {
    private static $cache = false;

    public static function init() {
        if (!Config::$cache) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
            Config::$cache = true;
        }
    }

    public static function get($key, $default = null) {
        return getenv($key) ?? $default;
    }

}