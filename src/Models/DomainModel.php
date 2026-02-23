<?php

namespace App\Models;

class DomainModel
{
    private const MAX_DOMAIN_LENGTH = 253;

    public function __construct(
        public string $domain,
    ){
        $this->domain = strtolower($domain);
    }

    public function validate(): array
    {
        $errors = [];

        $domain = strtolower(trim($this->domain));

        if (strlen($domain) > self::MAX_DOMAIN_LENGTH) {
            $errors[] = 'Domain name must not exceed ' . self::MAX_DOMAIN_LENGTH . ' characters.';
        }

        if (!preg_match('/^[a-z0-9]([a-z0-9\-\.]*[a-z0-9])?(\.[a-z]{2,})$/', $domain)) {
            $errors[] = 'Domain name is invalid (e.g. example.com or sub.example.com).';
        }

        return $errors;
    }
}