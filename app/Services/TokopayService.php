<?php

namespace App\Services;

use CodeIgniter\HTTP\Exceptions\HTTPException;

class TokopayService
{
    protected $baseUrl;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = env('TOKOPAY_BASE_URL');
        $this->secretKey = env('TOKOPAY_SECRET_KEY');
    }

    public function createTransaction($transactionData)
    {
        $client = \Config\Services::curlrequest();
        $headers = [
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json'
        ];
        
        $response = $client->post("{$this->baseUrl}/transaction", [
            'headers' => $headers,
            'json' => $transactionData
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new HTTPException("Failed to create transaction.");
        }

        return json_decode($response->getBody(), true);
    }

    public function checkTransactionStatus($order_id)
    {
        $client = \Config\Services::curlrequest();
        $headers = [
            'Authorization' => 'Bearer ' . $this->secretKey,
        ];

        $response = $client->get("{$this->baseUrl}/transaction/{$order_id}", [
            'headers' => $headers
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new HTTPException("Failed to retrieve transaction status.");
        }

        return json_decode($response->getBody(), true);
    }
}
