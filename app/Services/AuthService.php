<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends Service
{
    /**
     * @param array $data
     *
     * @return User
     */
    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::query()->create($data);
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return string
     * @throws ModelNotFoundException
     */
    public function login(string $email, string $password): string
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return Auth::user()->createToken('token')->plainTextToken;
        }

        throw new ModelNotFoundException("Email or password is invalid");
    }
}
