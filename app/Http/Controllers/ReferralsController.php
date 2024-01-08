<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Referrals;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
      $response = [
        'status' => 201,
        'referral' => $referral,
        'message' => 'Referral created successfully',
      ];
    } catch (ValidationException $e) {
      // Handle validation errors
      $response = [
        'status' => 422,
        'message' => $e->validator->errors()->first(),
        'errors' => $e->validator->errors(),
      ];
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

  public function updateReferrals(Request $request, $id)
  {
    try {
      // validate the request data
      $validatedData = $request->validate([
        'status' => 'required',
        'reward_type' => 'required',
        'reward_value' => 'required',
        'expiration_date' => 'required|date',
      ]);

      //Find the referral by id
      $referral = Referrals::findorFail($id);

      //update referral details 
      $referral->update($validatedData);

      // return the json response
      $response = [
        'status' => 200,
        'referral' => $referral,
        'message' => 'Referral details updated successfully',
      ];
    } catch (Exception $error) {
      // Handle any exceptions
      $response = [
        'status' => 500,
        'message' => $error->getMessage(),
      ];
    }

    return response()->json($response);
  }

  public function simulateUserPurchase(Request $request, $id)
  {
    try {
      // getting the authenticated user
      $user = $request->user();

      // find the referral by id
      $referral = Referrals::findOrFail($id);

      // create a new order for the referred user
      $order = Order::create([
        "user_id" => $referral->referred_user_id,

      ]);

      // updating the referral status to indicate a successful purchase
      $referral->update(['status' => 'Completed']);

      // return a JSON response with the simulated purchase details
      $response = [
        'status' => 200,
        'order' => $order,
        'message' => 'Simulated purchase successful'
      ];
    } catch (Exception $error) {
      //Handle any occured exception
      $response = [
        'status' => 500,
        'message' => $error->getMessage(),
      ];
    }

    return response()->json($response);
  }
}
