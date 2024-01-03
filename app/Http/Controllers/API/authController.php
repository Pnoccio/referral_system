<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
  use HttpResponses;

  //registering user
  public function register(Request $request)
  {
    try {
      $credentials = new User();
      $credentials->name = $request->name;
      $credentials->email = $request->email;
      $credentials->password = Hash::make($request->password);
      $credentials->role_id = $request->role_id;
      $credentials->save();
      $token = $credentials->createToken('Auth Token')->plainTextToken;
      $response = $this->success_message([
        'token' => $token,
      ], 'Congrats you have created your account successfully', 200);
    } catch (Exception $error) {
      $response = [
        'status' => 500,
        'message' => $error->getMessage()
      ];
    }
    return response()->json($response);
  }

  // login user
  public function login(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
      $token = $user->createToken('Personal Access Token')->plainTextToken;
      $response = [
        'status' => 200,
        'token' => $token,
        'user' => $user,
        'message' => 'Successfully Login! Welcome Back'
      ];
    } else if (!$user) {
      $response = [
        'status' => 401,
        'message' => 'No account found with this email'
      ];
    } else {
      $response = [
        'status' => 500,
        'message' => 'Wrong email or password! Please try again'
      ];
    }
    return response()->json($response);
  }

  // logout method
  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'User logged out']);
  }

  // fetching user information functionality
  public function userProfile(Request $request)
  {
    try {
      $user = $request->user();

      // attempting to retrieve token
      $token = $request->bearerToken();

      $response = [
        'status' => 200,
        'token' => $token,
        'user' => $user,
        'message' => 'message retrieved successfully',
      ];
    } catch (Exception $error) {
      $response = ['status' => 500, 'message' => $error->getMessage()];
    }
    return response()->json($response);
  }
}
