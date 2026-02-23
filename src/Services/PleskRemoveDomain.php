<?php

namespace App\Services;

use App\Config;
use App\Models\DomainModel;
use App\Services\PleskApiClient;
use RuntimeException;

class PleskRemoveDomain extends PleskApiClient
{
    public function __construct(
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
    <site>
        <del>
            <result>
                <status>ok</status>
                <id>18</id>
                <errcode>1013</errcode>
                <errtext>Object not found.</errtext>
            </result>
        </del>
    </site>
</packet>
";

        return $this->parseResponse($response, 'site', 'del');
    }

    public function parseResponse(string $xmlResponse, $node, $operation): static
    {
        parent::parseResponse($xmlResponse, $node, $operation);

        return $this;
    }

    private function buildCreateDomainXml(): string
    {
        $domain   = $this->convertToXml($this->domainModel->domain);
        $webspaceId   = $this->convertToXml($this->webspaceId);

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<packet version="1.6.9.1">
    <site>
        <del>
            <filter>
                <id>{$webspaceId}</id>
            </filter>
        </del>
        <del>
            <filter>
                <name>{$domain}</name>
            </filter>
        </del>
    </site>
</packet>
XML;
    }
}