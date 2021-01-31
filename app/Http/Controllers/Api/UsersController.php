<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $search = request('name');

        $val = User::where('name', 'LIKE', "$search%")
            ->take(5)->pluck('name');

        return $val->map(function ($name){
            return ['value' => $name];
        });
    }
}
