<?php

namespace App\Services;

use App\Config;
use App\Models\DomainModel;
use App\Models\FtpModel;
use App\Services\PleskApiClient;
use RuntimeException;

class PleskCreateFtp extends PleskApiClient
{
    public function __construct(
        private readonly FtpModel $ftpModel,
        private readonly DomainModel $domainModel,
        private readonly int $webspaceId
    ){
        parent::__construct();
    }

    public function send(): static
    {
        $xml = $this->buildCreateDomainXml();
        //$response = $this->request($xml);
        $response = "<packet>
    <ftp-user>
        <add>
            <result>
                <status>error</status>
                <id>18</id>
                <errcode>1013</errcode>
                <errtext>Object not found.</errtext>
            </result>
        </add>
    </ftp-user>
</packet>
";

        return $this->parseResponse($response, 'ftp-user', 'add');
    }

    public function parseResponse(string $xmlResponse, $node, $operation): static
    {
        parent::parseResponse($xmlResponse, $node, $operation);

        return $this;
    }

    private function buildCreateDomainXml(): string
    {
        $webspaceId   = $this->convertToXml($this->webspaceId);
        $domain   = $this->convertToXml($this->domainModel->domain);
        $ftp_user = $this->convertToXml($this->ftpModel->ftp_username);
        $ftp_password = $this->convertToXml($this->ftpModel->ftp_password);

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<packet version="1.6.9.1">
    <ftp>
        <create-acct>
            <webspace-name>{$domain}</webspace-name>
            <webspace-id>{$webspaceId}</webspace-id>
            <name>{$ftp_user}</name>
            <password>{$ftp_password}</password>
            <home>/</home>
            <create-non-existent>true</create-non-existent>
        </create-acct>
    </ftp>
</packet>
XML;
    }
}