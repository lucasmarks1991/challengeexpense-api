<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return UserResource
     */
    public function getLoggedUser(Request $request)
    {
        return new UserResource(Auth::user());
    }
}
