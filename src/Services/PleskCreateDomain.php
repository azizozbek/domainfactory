<?php

namespace App\Services;

use App\Config;
use App\Models\DomainModel;
use App\Services\PleskApiClient;
use RuntimeException;

class PleskCreateDomain extends PleskApiClient
{
    public int $webspaceId;

    public function __construct(
        private readonly DomainModel $domainModel
    ){
        parent::__construct();
    }

    public function send(): static
    {
        $xml = $this->buildCreateDomainXml();
        //$response = $this->request($xml);
        $response = "<packet>
    <site>
        <add>
            <result>
                <status>error</status>
                <id>18</id>
                <errcode>1013</errcode>
                <errtext>Object not found.</errtext>
            </result>
        </add>
    </site>
</packet>
";

        return $this->parseResponse($response, 'site', 'add');
    }

    public function parseResponse(string $xmlResponse, $node, $operation): static
    {
        parent::parseResponse($xmlResponse, $node, $operation);

        if (count($this->errors) > 0) {

            return $this;
        }

        if ($this->success) {
            $this->webspaceId = (int)$this->result->id;
        }

        return $this;
    }

    private function buildCreateDomainXml(): string
    {
        $ip_address = Config::get('PLESK_IP_ADDRESS'); // get from plesk if multiple exist
        $domain   = $this->convertToXml($this->domainModel->domain);

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<packet version="1.6.9.1">
    <webspace>
        <add>
            <gen_setup>
                <name>{$domain}</name>
                <ip_address>{$ip_address}</ip_address>
            </gen_setup>
        </add>
    </webspace>
</packet>
XML;
    }
}