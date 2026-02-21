<?php

namespace App\Models;

class DomainModel
{
    private const MAX_DOMAIN_LENGTH = 253;

    public string $domain;
    public string $ftp_username;
    public string $ftp_password;

    public function validate(): array|bool
    {
        $errors = [];
        if ($this->domain === '' || $this->ftp_username === '' || $this->ftp_password === '') {
            return ['All fields are required.'];
        }

        $errors = array_merge($errors, $this->validateDomain());
        $errors = array_merge($errors, $this->validateFTPPassword());

        if (count($errors) > 0) {
            return $errors;
        }

        return true;
    }

    public function validateDomain() {

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

    public function validateFTPPassword() {

        // Merged composition rule
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $this->ftp_password)) {
            return ['FTP password must contain at least one uppercase letter, one lowercase letter, and one digit.'];
        }

    }
}