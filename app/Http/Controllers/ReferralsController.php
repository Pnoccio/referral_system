<?php

namespace App\Http\Controllers;

use App\Models\Referrals;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ReferralsController extends Controller
{
  public function store(Request $request)
  {
    try {
      // validate the request data
      $validatedData = $request->validate([
        'referrer_user_id' => 'required|exists:users,id',
        'referred_user_id' => 'required|exists:users,id',
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

  public function index(Request $request)
  {
    try {
      // fetching all the referrals
      $referrals = Referrals::all();

      // returning a json response with the referrals
      $response = [
        'status' => 200,
        'referral' => $referrals,
        'message' => 'Referrals retrieved successfully',
      ];
    } catch (Exception $error) {
      // Handling Exception
      $response = [
        'status' => 400,
        'message' => $error->getMessage()
      ];
    }

    return response()->json($response);
  }

  public function userReferrals(Request $request)
  {
    try {
      // get the authenticated user
      $user = $request->user();

      // fetch the user's referral history
      $userReferrals = Referrals::where('referrer_user_id', $user->id)->get();

      // return the Json response with the referral history
      $response = [
        'status' => '200',
        'user_referral' => $userReferrals,
        'message' => 'User\'s referral(s) history have been retrieved sucessfully',
      ];
    } catch (Exception $error) {
      // handle the exception 
      $response = [
        'status' => 500,
        'message' => $error->getMessage(),
      ];
    }

    return response()->json([$response]);
  }
}
