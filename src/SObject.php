<?php

namespace drilonnikci\PhpSalesforceApi;

use drilonnikci\PhpSalesforceApi\traits\LoggerTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SObject
{
    private SalesforceAuthRequest $salesforce;
    private string $sobjectUrl;
    private string $dataUrl;
    private array $headers;

    use LoggerTrait;

    public function __construct(SalesforceAuthRequest $salesforce) {
        $this->salesforce = $salesforce;
        $instanceUrl = $this->salesforce->getInstanceUrl();
        $this->dataUrl = "{$instanceUrl}/services/data/v58.0";
        $this->sobjectUrl = $this->dataUrl . '/sobjects';
        $this->headers = $this->salesforce->getHeaders();
    }

    public function create($object, $data): false|string
    {
        try {
            $client = new Client();
            $uri = $this->sobjectUrl . "/{$object}";
            $response = $client->post($uri, ['headers' => $this->headers, 'json' => $data]);
            $message = [
                'status' => $response->getReasonPhrase(),
                'code' => $response->getStatusCode(),
                'body' => json_decode($response->getBody()),
            ];

            $this->getLogger()->notice("{$object} was created", $message);
        } catch (GuzzleException $exception) {
            $message = [
                'status' => 'Failed',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
            $this->getLogger()->error("{$object} wasn't created. ",  $message);
        }

        return json_encode($message);
    }
}