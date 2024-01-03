<?php

namespace App\Http\Controllers;

use App\Models\Referrals;
use Exception;
use Illuminate\Http\Request;

class ReferralsController extends Controller
{
  public function store(Request $request){
    try {
      // validate the request data
      $validatedData = $request->validate([
        'referrer_user_id' => 'required|exists:users, id',
        'referred_user_id' => 'required|exists:users, id',
        'status' => 'required',
        'reward_type' => 'required',
        'reward_value' => 'required',
        'expiration_date' => 'required|date',
      ]);

      // creating new referral 
      $referral = Referrals::create($validatedData);
      $reponse = [
        'status' => 201,
        'referral' => $referral,
        'message' => 'Referral created successfully',
      ];

      $response = [];
    } catch (Exception $error) {
      $response = [
        'status' => 500,
        'message' => $error->getMessage(),
      ];
    }
    return response()->json($response);
  }
}
