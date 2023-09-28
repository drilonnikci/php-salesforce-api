<?php

namespace drilonnikci\PhpSalesforceApi\Authentication;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SalesforceAuthRequest
{
    private string $loginUrl;
    private string $instanceUrl;
    private string $accessToken;
    private array  $headers;

    private array $credentials;

    /**
     * @param array $credentials
     * @param bool $sandbox
     */
    public function __construct(array $credentials, bool $sandbox)
    {
        $this->credentials = $credentials;
        $this->loginUrl = 'https://' . ($sandbox ? 'test' : 'login') . '.salesforce.com';
        $this->authenticate();
    }

    /**
     * @return string
     */
    public function getLoginUrl(): string
    {
        return $this->loginUrl;
    }

    /**
     * @return string
     */
    public function getInstanceUrl(): string
    {
        return $this->instanceUrl;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }


    private function authenticate(): void
    {
        $client = new Client();

        try {
            $uri = "{$this->loginUrl}/services/oauth2/token";
            $response = $client->post($uri, ['form_params' => $this->credentials]);
            $data = json_decode($response->getBody());

            $this->accessToken = $data->access_token;
            $this->instanceUrl = $data->instance_url;
            $this->headers = ['Authorization' => "Bearer " . $this->accessToken, 'Content-Type' => 'application/json'];
        } catch (GuzzleException $e) {
            var_dump($e->getMessage());
        }
    }
}