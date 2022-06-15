<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterUserRequest;

class RegisterController extends Controller
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
     * Register the user into system.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json([], 201);
    }

}
