<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;


class RegisterController extends Controller
{
    public function formRegister()
    {
        return view('authentication.register.register');
    }

    public function createUser(RegisterRequest $request)
    {
        try {
            $newUser = User::create([
                                'name' => $request->name,
                                'email' => $request->email,
                                'password' => password_hash($request->password,PASSWORD_BCRYPT)
                            ]);

            if ($newUser)
                return redirect()->route('login.index')->with(['success' => "User registered successfully! Log in."]);
            else
                throw new \Exception("Error creating user, contact IT support.");
        }catch (\Exception $e){
            return redirect()->route('register.index')->withErrors(["Error: {$request->getMessage()}."]);
        }
    }
}
