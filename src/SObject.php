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
    private Client $httpClient;

    use LoggerTrait;

    public function __construct(SalesforceAuthRequest $salesforce) {
        $this->salesforce = $salesforce;
        $instanceUrl = $this->salesforce->getInstanceUrl();
        $this->dataUrl = "{$instanceUrl}/services/data/v58.0";
        $this->sobjectUrl = $this->dataUrl . '/sobjects';
        $this->headers = $this->salesforce->getHeaders();
        $this->httpClient = new Client(['headers' => $this->headers]);
    }


    /**
     * @param string $object
     * @param array $data
     *  Create a record on Salesforce e.g. Lead, Opportunity
     * @return false|string
     */
    public function create(string $object, array $data): false|string
    {
        try {
            $uri = $this->sobjectUrl . "/{$object}";
            $response = $this->httpClient->post($uri, ['headers' => $this->headers, 'json' => $data]);
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

    /**
     * @param string $object
     * @param string $recordId
     * @param array $data
     * Update record on salesforce
     * @return false|string
     */
    public function update(string $object, string $recordId, array $data): false|string
    {
        try {
            $uri = $this->sobjectUrl . "/{$object}/{$recordId}";
            $response = $this->httpClient->patch($uri, ['json' => $data]);
            $message = [
                'status' => $response->getReasonPhrase(),
                'code' => $response->getStatusCode(),
                'body' => json_decode($response->getBody()),
            ];

            $this->getLogger()->notice("{$object} with id {$recordId} updated", $message);
        } catch (GuzzleException $exception) {
            $message = [
                'status' => 'Failed',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
            $this->getLogger()->error("{$object} with id {$recordId} wasn't updated. ",  $message);
        }

        return json_encode($message);
    }
}