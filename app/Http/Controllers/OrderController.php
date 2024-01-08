<?php

namespace App\Http\Controllers;

use Exception;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use Illuminate\Http\Request;

class OrderController extends Controller
{
  public function processOrderPayment(Request $request, $id){
    try {
      // find 
    } catch (Exception $error) {
      //throw $th;
    }
  }
}
