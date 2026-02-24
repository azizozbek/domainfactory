<?php

namespace App\Services;

use App\Config;
use App\Models\DomainModel;
use App\Models\FtpModel;
use App\Services\PleskApiClient;
use RuntimeException;

class PleskGetWebspaces extends PleskApiClient
{
    private CacheService $cacheService;
    public array $webspaces = [];
    public function __construct()
    {
        $this->cacheService = CacheService::getInstance();
        $cache = $this->cacheService->get("webspaces");
        if ($cache) {
            $this->webspaces = $cache;

            return;
        }

        parent::__construct();
    }

    public function send(): static
    {
        $xml = $this->buildCreateDomainXml();

        $response = $this->mockResponse();
        if (!Config::get('DEBUG')) {
            $response = $this->request($xml);
        }

        return $this->parseResponse($response, 'webspace', 'get');
    }

    public function parseResponse(string $xmlResponse, string $node, string $operation): static
    {
        parent::parseResponse($xmlResponse, $node, $operation);

        if (count($this->errors) > 0) {

            return $this;
        }

        foreach ($this->result as $webspace) {
            $this->webspaces[$webspace->id] = [
                'name' => $webspace->data->gen_info->name,
                'status' => $webspace->data->gen_info->status,
                'created' => $webspace->data->gen_info->cr_date,
            ];
        }

        $this->cacheService->set("webspaces", $this->webspaces);

        return $this;
    }

    private function buildCreateDomainXml(): string
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<packet>
    <webspace>
        <get>
            <filter/>
            <dataset>
                <gen_info/>
            </dataset>
        </get>
    </webspace>
</packet>
XML;
    }

    private function mockResponse(): string
    {
        return "<packet>
    <webspace>
        <get>
            <result>
                <data>
                    <gen_info>
                        <name>example.com</name>
                        <status>0</status>
                    </gen_info>
                </data>
            </result>
        </get>
    </webspace>
</packet>
";
    }
}