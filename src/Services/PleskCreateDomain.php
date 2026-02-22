<?php

namespace App\Services;

use App\Config;
use App\Models\DomainModel;
use App\Services\PleskApiClient;
use RuntimeException;

class PleskCreateDomain
{
    public function __construct(
        private readonly DomainModel $domainModel
    )
    {
        $plesk_api = Config::get('PLESK_API_URL');
        $plesk_username = Config::get('PLESK_USERNAME');
        $plesk_password = Config::get('PLESK_PASSWORD');

        $client = new PleskApiClient($plesk_api);
        $client->setCredentials($plesk_username, $plesk_password);
        $xml = $this->buildCreateDomainXml();

        $response = $client->request($xml);
        var_dump($response);die();
        return $this->parseResponse($response, 'webspace', 'add');
    }

    private function buildCreateDomainXml(): string
    {
        $ip_address = Config::get('PLESK_IP_ADDRESS'); // get from plesk if multiple exist
        $domain   = $this->domainModel->convertToXml($this->domainModel->domain);
        $ftp_user = $this->domainModel->convertToXml($this->domainModel->ftp_username);
        $ftp_password = $this->domainModel->convertToXml($this->domainModel->ftp_password);

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<packet version="1.6.9.1">
    <webspace>
        <add>
            <gen_setup>
                <name>{$domain}</name>
                <ip_address>{$ip_address}</ip_address>
            </gen_setup>
            <hosting>
                <vrt_hst>
                    <property>
                        <name>ftp_login</name>
                        <value>{$ftp_user}</value>
                    </property>
                    <property>
                        <name>ftp_password</name>
                        <value>{$ftp_password}</value>
                    </property>
                    <ip_address>{$ip_address}</ip_address>
                </vrt_hst>
            </hosting>
        </add>
    </webspace>
</packet>
XML;
    }

    private function parseResponse(string $xmlResponse, string $node, string $operation): array
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlResponse);

        if ($xml === false) {
            $errors = libxml_get_errors();
            libxml_clear_errors();

            var_dump($errors); //todo
        }

        $result = $xml->{$node}->{$operation}->result ?? null;

        var_dump($result); //todo
    }
}