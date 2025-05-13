<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;

class APIExchange
{

    public static string $base_api = "http://api.exchangeratesapi.io/v1/";
    public static string $api_key = "02f933c88c96e0c0341ec000491ead5c";

    public static function get($endpoint, $query_param)
    {
        try {
            $query_param['access_key'] = self::$api_key;
            $response = Http::get(self::$base_api . $endpoint, $query_param);

            if ($response->successful()) {
                $data = $response->json();
                return $data;
            } else {
                return [['error' => 'API request failed'], $response->status()];
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the request
            return ['error' => $e->getMessage()];
        }
    }
}


