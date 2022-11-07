<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $name = Str::random(6);
        $email = $request->email;
        $password = $request->password;

        // 本地头像
        $path = '/images/avatar/default/';
        $avatars = [
            'avatar00.jpeg',
            'avatar01.jpeg',
            'avatar02.jpeg',
            'avatar03.jpeg',
            'avatar04.jpeg',
        ];
        $avatar = $avatars[mt_rand(0, 4)];
        $localAvatar = $path.$avatar;

        // 网络头像
        $response = Http::get('http://api.btstu.cn/sjtx/api.php?lx=c1&format=json&method=mobile');
        if ( !empty($response->body()) ){
            $json = json_decode($response->body());
            if ( $json->code == 200 ){
                $avatarUrl = $json->imgurl;
            }else{
                $avatarUrl = "";
            }
        }

        $user = User::create([
            'avatar' => $avatarUrl ?? $localAvatar,
            'name'  => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        return new UserResource($user);
    }
}
