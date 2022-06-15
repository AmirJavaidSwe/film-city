<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Resources\V1\UserResource;

class LoginController extends Controller
{

    public $user;

    /**
     * Create a new Film model instance.
     *
     * @param  array  $attributes
     * @return void
     */

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Login the user into system.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return new UserResource(Auth::user());
        }
        return response()->json([
            'errors' => [
                'email' => ['The provided credentials do not match our records.']
            ]
        ], 422);
    }

}
