<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\TokenResource;
use App\Http\Resources\User\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
    protected AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param RegisterRequest $request
     *
     * @return JsonResource
     */
    public function register(RegisterRequest $request): JsonResource
    {
        $user = $this->service->register(
            $request->only(['name', 'email', 'password']),
        );

        return new UserResource($user);
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResource
     */
    public function login(LoginRequest $request): JsonResource
    {
        $token = $this->service->login(
            $request->get('email'),
            $request->get('password'),
        );

        return new TokenResource((object) ['token' => $token]);
    }
}
