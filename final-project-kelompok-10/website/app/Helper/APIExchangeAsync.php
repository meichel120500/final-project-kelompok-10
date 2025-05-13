<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;

class APIExchangeAsync
{
    
    public string $base_api = "http://api.exchangeratesapi.io/v1/";
    public string $api_key = "81708fdea4edc84b5df8247f9936b8d9";

    public $client;
    public $promises;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->promises = array();
    }

    public function add_get($name, $endpoint, $query_param)
    {
        $query_param['access_key'] = $this->api_key;
        $this->promises[$name] = $this->client->getAsync($this->base_api.$endpoint, [
            'query' => $query_param,
        ])
        ->then(
            function (ResponseInterface $res){
                $response = json_decode($res->getBody()->getContents(), true);
                return $response;
            }
        );
    }

    public function wait()
    {
        $responses = \GuzzleHttp\Promise\Utils::settle($this->promises)->wait();
        return $responses;
    }

    public function get_promises()
    {
        return $this->promises;
    }

    public function clear()
    {
        $this->promises = array();
    }
}


