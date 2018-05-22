<?php

namespace App;
use GuzzleHttp\Client;

class fixerio {

    private $url = 'https://api.fixer.io/latest';

    public function calculate($amount, $from, $to) {
        $rate = $this->getRate($from, $to);
        $price = $amount * $rate;
        return $price;
    }

    private function getRate($from, $to) {
        $rate = 0;
        if (!in_array($from, config('currencies')) || !in_array($to, config('currencies'))) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(200, 'Error getting currency code from config file');
        }
        $client = new Client();
        $parameters['base'] = $from;
        $parameters['symbols'] = $to;
        $response = $client->get($this->url, ['query' => $parameters]);
        $response_array = json_decode($response->getBody());
        $rates = $response_array->rates;
        if (isset($rates->$to)) {
            $rate = $rates->$to;
        }
        return $rate;
    }

}
