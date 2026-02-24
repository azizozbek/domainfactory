<?php
// Copyright 1999-2016. Parallels IP Holdings GmbH. All Rights Reserved.

namespace App\Services;

use App\Config;
use SimpleXMLElement;

/**
 * Client for Plesk API-RPC
 */
abstract class PleskApiClient
{
    private string $_host;
    private string $_login;
    private string $_password;

    public array $errors = [];
    public bool $success = false;
    public array $result = [];


    public function __construct()
    {
        $this->_host = Config::get('PLESK_API_URL');
        $this->_login = Config::get('PLESK_USERNAME');
        $this->_password = Config::get('PLESK_PASSWORD');
    }

    public function request($request)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://$this->_host:8443/enterprise/control/agent.php");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->_getHeaders());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        if (Config::get('DEBUG')) {
            curl_setopt($curl, CURLOPT_VERBOSE, true);
        }

        $result = curl_exec($curl);

        if ($result === false) {
            $errno  = curl_errno($curl);
            $error  = curl_error($curl);
            $info   = curl_getinfo($curl);

            if (Config::get('DEBUG')) {
                var_dump($errno, $error, $info);
                error_log("cURL error ({$errno}): {$error}");
                error_log("cURL info: " . print_r($info, true));
            }
        }

        curl_close($curl);

        return $result;
    }

    private function _getHeaders()
    {
        $headers = array(
            "Content-Type: text/xml",
            "HTTP_PRETTY_PRINT: TRUE",
        );

        $headers[] = "HTTP_AUTH_LOGIN: $this->_login";
        $headers[] = "HTTP_AUTH_PASSWD: $this->_password";

        return $headers;
    }

    public function convertToXml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1);
    }


    protected function parseResponse(string $xmlResponse, string $node, string $operation): static
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlResponse);

        if ($xml === false) {
            $this->errors = libxml_get_errors();
            libxml_clear_errors();

            return $this;
        }

        $jsonResponse = json_decode(json_encode($xml->{$node}->{$operation}), false);
        $this->result = (is_array($jsonResponse->result)) ? $jsonResponse->result : [$jsonResponse->result];

        if (count($this->result) === 0) {
            $this->errors[] = "Unexpected response";

            return $this;
        }

        if (count($this->result) > 1) {

            return $this;
        }

        $result = $this->result[0];
        $status = (string) $result->status;
        if ($status === 'ok') {
            $this->success = true;

            return $this;
        }

        $errCode = (int) ($result->errcode ?? 0);
        $error   = PleskErrorCodesEnum::tryFrom($errCode);
        $message = $error ? $error->message() : (string) ($result->errtext ?? 'Unknown error.');

        $this->errors[] = $errCode . ' - ' . $message;

        return $this;
    }
}