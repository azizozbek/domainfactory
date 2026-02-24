<?php

namespace App\Models;

class FtpModel
{
    private const int MIN_FTP_PASSWORD_LENGTH = 5;
    private const int MAX_FTP_PASSWORD_LENGTH = 255;
    public const FTP_USERNAME_FIELD = 'ftp_username';
    public const FTP_PASSWORD_FIELD = 'ftp_password';

    public function __construct(
        public string $ftp_username,
        public string $ftp_password
    ){
        $this->ftp_username = trim($ftp_username);
        $this->ftp_password = trim($ftp_password);
    }

    public function validate(): array
    {
        $errors = [];

        $length = strlen($this->ftp_password);

        if ($length < self::MIN_FTP_PASSWORD_LENGTH) {
            $errors[] = 'FTP password must be at least ' . self::MIN_FTP_PASSWORD_LENGTH . ' characters long.';
        }

        if ($length > self::MAX_FTP_PASSWORD_LENGTH) {
            $errors[] = 'FTP password must not exceed ' . self::MAX_FTP_PASSWORD_LENGTH . ' characters.';
        }

        if (preg_match('/[\s\'"]/', $this->ftp_password)) {
            $errors[] = 'FTP password must not contain quotes or spaces.';
        }

        if (preg_match('/[^\x00-\x7F]/', $this->ftp_password)) {
            $errors[] = 'FTP password must not contain national alphabet characters.';
        }

        if (str_contains($this->ftp_password, $this->ftp_username)) {
            $errors[] = 'FTP password must not contain the username.';
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $this->ftp_password)) {
            $errors[] = 'FTP password must contain at least one uppercase letter, one lowercase letter, and one digit.';
        }

        return $errors;

    }

}