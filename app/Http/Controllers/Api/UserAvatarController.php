<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAvatarController extends Controller
{

    public function store()
    {
        \request()->validate([
            'avatar' => ['required', 'image']
        ]);
    }
}
