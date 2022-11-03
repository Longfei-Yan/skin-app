<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $name = Str::random(20);
        $email = $request->email;
        $password = $request->password;
        $path = '/images/avatar/default/';
        $avatars = [
            'avatar00.jpeg',
            'avatar01.jpeg',
            'avatar02.jpeg',
            'avatar03.jpeg',
            'avatar04.jpeg',
        ];
        $avatar = $avatars[mt_rand(0, 4)];

        $user = User::create([
            'avatar' => $path.$avatar,
            'name'  => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        return new UserResource($user);
    }
}
