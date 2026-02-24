<?php

namespace App\Services;

use App\Config;
use App\Models\DomainModel;
use App\Models\FtpModel;
use App\Services\PleskApiClient;
use RuntimeException;

class PleskCreateWebspace extends PleskApiClient
{
    public function __construct(
        private readonly DomainModel $domainModel,
        private readonly FtpModel $ftpModel,
    ){
        parent::__construct();
    }

    public function send(): static
    {
        $xml = $this->buildCreateDomainXml();

        $response = $this->mockResponse();
        if (!Config::get('DEBUG')) {
            $response = $this->request($xml);
        }

        CacheService::getInstance()->forget('webspaces');

        return $this->parseResponse($response, 'webspace', 'add');
    }

    private function buildCreateDomainXml(): string
    {
        $ip_address     = Config::get('PLESK_IP_ADDRESS'); // get from plesk if multiple exist
        $domain         = $this->convertToXml($this->domainModel->domain);
        $ftp_username   = $this->convertToXml($this->ftpModel->ftp_username);
        $ftp_password   = $this->convertToXml($this->ftpModel->ftp_password);

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<packet>
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
                        <value>{$ftp_username}</value>
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

    private function mockResponse(): string
    {
        return "<packet>
    <webspace>
        <add>
            <result>
                <status>ok</status>
                <id>18</id>
                <errcode>1013</errcode>
                <errtext>Object not found.</errtext>
            </result>
        </add>
    </webspace>
</packet>
";
    }
}