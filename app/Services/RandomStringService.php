<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RandomStringService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('RANDOM_STRING_API_URL', 'https://www.random.org/strings');
    }

    public function getRandomString(array $params): string|bool
    {
        $getParams = [
            'num' => $params['num'],
            'len' => $params['len'],
            'digits' => $params['digits'] ? 'on' : 'off',
            'unique' => $params['unique'] ? 'on' : 'off',
            'upperalpha' => $params['upperalpha'] ? 'on' : 'off',
            'loweralpha' => $params['loweralpha'] ? 'on' : 'off',
            'format' => 'plain',
        ];
        $url = $this->apiUrl . '?' . http_build_query($getParams);

        try {
            $response = Http::get($url);
            $data = $response->body();
        } catch (\Exception $e) {
            $data = false;
        }

        return $data;
    }
}