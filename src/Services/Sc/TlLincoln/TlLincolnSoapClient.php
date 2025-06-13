<?php

namespace ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln;

use ThachVd\LaravelSiteControllerApi\Models\ScApiLog;
use ThachVd\LaravelSiteControllerApi\Services\Sc\Xml2Array\Xml2Array;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class TlLincolnSoapClient
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     *
     */
    public const STATUS_CODE_ERROR = 500;
    /**
     * @var Client
     */
    protected $client;

    /**
     *
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param array $headers
     * @return void
     */
    public function setHeaders(array $headers = [])
    {
        $commonHeaders = [
            'Content-Type' => 'text/xml',
        ];

        $this->options['headers'] = array_merge($commonHeaders, $headers);
    }

    /**
     * @param array $queryParams
     * @return void
     */
    public function setQueryParams(array $queryParams = [])
    {
        $this->options['query'] = array_merge($this->options['query'] ?? [], $queryParams);
    }

    /**
     * @param $method
     * @return void
     */
    public function setMethod($method)
    {
        $this->options['method'] = $method;
    }

    /**
     * @param $body
     * @return void
     */
    public function setBody($body): void
    {
        $this->options['body'] = $body;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->options['body'] ?? [];
    }

    public function getQueryParams()
    {
        return $this->options['query'] ?? [];
    }

    /**
     * @param $url
     * @param $options
     * @return mixed|string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callSoapApi($url, $options = [])
    {
        $this->options = array_merge($this->options, $options);
        if (!isset($this->options['method'])) {
            $this->options['method'] = 'POST';
        }

        try {
            // send request
            $response = $this->client->request($this->options['method'], $url, $this->options);
            $scApiLog = [
                'url' => $url,
                'method' => $this->options['method'],
                'request' => $this->options['body'] ?? [],
            ];
            $scApiLog['status_code'] = $response->getStatusCode();
            $scApiLog['response'] = $response->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            \Log::error('API connection failed - URL: ' . $url);
            \Log::error($e);

            $scApiLog = [
                'status_code' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : self::STATUS_CODE_ERROR,
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage(),
                'url' => $url,
                'method' => $this->options['method'],
            ];
        } catch (\Exception $e) {
            \Log::error('API connection failed - URL: ' . $url);
            \Log::error($e);

            $scApiLog = [
                'status_code' => self::STATUS_CODE_ERROR,
                'response' => $e->getMessage(),
                'url' => $url,
                'method' => $this->options['method'],
            ];
        }

        $this->saveLog($scApiLog);

        return $scApiLog['response'] ?? null;
    }

    /**
     * Convert response soap API to array
     * @param string $response
     * @param string $body
     * @return array
     */
    public function convertResponeToArray($response, $body = 'S:Body')
    {
        $dataSoap = Xml2Array::toArray($response);
        $arrSoap = isset($dataSoap[$body]) ? $dataSoap[$body] : [];

        return $arrSoap;
    }

    /**
     * @param array $log
     * @return void
     */
    public function saveLog(array $log)
    {
        // Implement the logic to write log data to the database
        try {
            DB::beginTransaction();
            ScApiLog::create($log);
            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollback();
        }
    }
}
