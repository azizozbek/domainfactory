<?php

namespace App;

use Dotenv\Dotenv;

class Config {
    private static $cache = false;

    public static function init() {
        if (!Config::$cache) {
            $dotenv = Dotenv::createUnsafeImmutable(realpath(__DIR__ . '/..'));
            $dotenv->load();
            Config::$cache = true;
        }
    }

    public static function get($key, $default = null) {

        $env = getenv($key) ?? $default;
        if ($env == "false" || $env == "true") {
            $env = filter_var($env, FILTER_VALIDATE_BOOLEAN);
        }

        return $env;
    }

}