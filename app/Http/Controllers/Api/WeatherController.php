<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class WeatherController extends Controller
{
    public function index()
    {
        $url = 'https://v0.yiketianqi.com/api';
        $response = Http::get($url, [
            'unescape' => '1',
            'version' => 'v91',
            'appid' => '43656176',
            'appsecret' => 'I42og6Lm',
            'cityid' => '',
            'city' => '',
        ]);
        $json = $response->json($key = null);

        if (isset($json['errcode']) && $json['errcode'] == 100){
            abort(422, $json['errmsg']);
        }

        $data = [
            'address' => $json['country'].$json['city'],
            'date' => $json['data'],
            'weather' => $json['data'],
        ];

        return $data;
    }
}
