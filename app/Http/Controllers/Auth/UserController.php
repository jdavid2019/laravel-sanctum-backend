<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
      //  $request->session()->regenerate();
        // return response()->json(null,201);
        //$token = $user->createToken($data['password'])->plainTextToken;
         return response()->json(
          [
              'token' => $request->user()->createToken($request->email)->plainTextToken,
              'message' => 'Success'
           ]
        );
    }

    public function register(Request $request) {

        $data = $request->validate([
           'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string'
        ]);
//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => bcrypt($request->pasword)
//        ]);
        $user = User::create([
          'name' => $data['name'],
           'email' => $data['email'],
           'password' => Hash::make($data['password'])
        ]);


        //$token = $user->createToken($data['password'])->plainTextToken;
        //return response()->json([ 'user' => $user, 'token' => $token ],200);
        return response()->json([ 'user' => $user],200);
    }

    public function logout(Request $request) {
        // lo utilizo en caso uso la sesión
       // auth()->guard('web')->logout();
        auth()->user()->tokens()->delete();
      //  $request->session()->invalidate();
       // $request->session()->regenerateToken();
        return response()->json("Token removed",200);
    }

}
