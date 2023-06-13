<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

     public function __construct(){
        $this->middleware(['auth:sanctum'])->only('logout', 'me');
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // mencari pengguna (user) dengan email yang cocok dengan nilai yang diberikan dalam permintaan (request) //
        $user = User::where('email', $request->email)->first();
 
        // memeriksa apakah pengguna dengan email yang diberikan dan kata sandi yang diberikan cocok dengan data yang ada dalam aplikasi //
        if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Password atau email anda Salah'],
        ]);
      } 

       return $user->createToken($user->username)->plainTextToken;

   }

   public function logout(Request $request){

    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Anda Telah Logout']);

   }

    public function me(){
    
    $user = Auth::user();

    return response()->json([
        'id' => $user->id,
        'username' => $user->username,
        'firstname' => $user->firstname,
        'lastname' => $user->lastname,
    ]);

   }

}
