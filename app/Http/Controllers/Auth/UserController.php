<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return response()->json(['data' => $data], 200);
    }


    public function login(Request $request) {
        $credentials = $request->only('email','password');
        $validator = Validator::make($credentials,
        [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong validation',
                'errors' =>   $validator->errors()
                ],422);
        }

        if(!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
               'message' => 'Invalid credentials'
            ]);
        }

        $request->session()->regenerate();

       return response()->json(null,201);
        // return response()->json(
        //     [
        //        'token' => $request->user()->createToken($request->name)->plainTextToken,
        //        'message' => 'Success'
        //    ]
        // );
    }

    public function register(Request $request) {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->pasword)
        ]);

        return response()->json([ 'message' => 'You are registered' ],200);
    }

    public function logout(Request $request) {
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(null,200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
