<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

  // login
  public function login(Request $request)
  {
    $request->validate([
      'email'    => 'email|required',
      'password' => 'required'
    ]);
    if (Auth::attempt(['email' =>  $request->email, 'password' =>  $request->password])) {

      $user = User::where('email', $request->email)->first();
      $tokon = $user->createToken('apiTokon' . $user->name)->plainTextToken;

      return response()->json([
        'status' => true,
        'message' => "Login successful",
        'tokon' => $tokon,

      ]);
    }
  }

  //////// register


  public function register(Request $request)
  {
    $request->validate([

      'name' => 'required',
      'email' => 'required|email|max:255',
      'password' => 'required|max:8',
      'confirm_password' => 'required|same:password',

    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);
    $tokon = $user->createToken('apiTokon' . $user->name)->plainTextToken;


    return response()->json([
      'status' => true,
      'message' => " register successful",
      'tokon' => $tokon,

    ]);
  }

  //  logout
  public function logOut(Request $request)
  {
    $request->user()->currentAccessToken()->delete();

    return response()->json([
      'status' => true,
      'message' => "Logout successful"
    ]);
  }


  // getuserinfo
  // public function getuserinfo(Request $request)
  // {
  //   $user = auth()->user();
  //   return response()->json([
  //     'status' => true,
  //     'user' => $user,
  //   ]);
  // }
}
