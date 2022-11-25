<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class WeatherController extends Controller
{
    public function index()
    {
        $url = "https://v0.yiketianqi.com/api
        ?unescape=1&version=v91&appid=43656176&appsecret=I42og6Lm&ext=&cityid=&city=";
        $response = Http::get($url);
        $json = $response->json($key = null);
        return $json->country.$json->city;
    }
}
